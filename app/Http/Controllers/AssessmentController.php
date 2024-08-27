<?php

namespace App\Http\Controllers;
use App\Models\Assessment;
use App\Models\QuestionBank;
use App\Models\AssessmentQuestion;
use Illuminate\Http\Request;
use App\Models\{Projects,ProjectTeam};
use App\Models\ProjectAssessment;
use Carbon\Carbon;
use Illuminate\Auth\Events\Validated;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use Symfony\Component\Console\Input\Input;
use Session;


class AssessmentController extends Controller{

    // Update : Sandeep Kr, 25/07/2024 : fix algo
    public function index(Request $request,$actionMode='NA'){
        $schedule = schedule;
        $query = Assessment::with('assessmentProjectId');

        if ($request->sdate) {
            $query->whereDate('created_at', '>=', $request->sdate);
        }

        if ($request->endDate) {
            $query->whereDate('created_at', '<=', $request->endDate);
        }

        if ( isset($request->typeFilter) && in_array($request->typeFilter,['measure','survey']) ) {
            $valType = $request->typeFilter == 'measure' ? 1 : 0;
            $query->where('scoring', '=' , $valType);
        }

        if ($request->status) {
            $query->where('status', '=' , $request->status);

        }

        if($request->search):
            // dd( $request->search);
            $titleSearch = str_replace("+","",$request->search);
            $query->where('title', 'like', "%{$titleSearch}%");
        endif;

        if ($request->projectId):
            $assessmentIds = ProjectAssessment::where('project_id',$request->projectId)->select('assessment_id')->get();

                $assessmentIds = $assessmentIds ? $assessmentIds->toArray() : [];
                if( count($assessmentIds) >= 1 ):
                    $assessIDs = array_column($assessmentIds,'assessment_id');
                    $query->whereIn('id',$assessIDs);
                else:
                    $query->where('id',0);
                endif;

        endif;


        $assessments = $query->orderBy('id','DESC')->paginate(5);

        $projectDetail = [];
        $filterStatus = isset($request->status) && !empty($request->status) ? $request->status : '';
        $typeFilter = isset($request->typeFilter) && !empty($request->typeFilter) ? $request->typeFilter : '';

        if( $request->projectId ):
            $projects = Projects::where('id',$request->projectId)->first();
            $projectDetail = $projects ? $projects->toArray() : [];
        endif;

        // dd( $query->toSql(), $query->getBindings(), $assessments->toArray());
        // dd( $assessments->toArray() );
        return view("assessment.index", ['assessments' => $assessments , 'schedule' => $schedule, 'filterStatus'=>$filterStatus,'typeFilter'=>$typeFilter, 'projectDetail'=>$projectDetail,'actionMode'=>$actionMode]);
    }

    public function create(){

        $userData = DB::table('users')->where('id',Session::get('user_id'))->first();

        $myProjects = ProjectTeam::where('user_id',Session::get('user_id'))->get('project_id');

        $myProjects = $myProjects ? $myProjects->toArray() : [];

        $myProjectIDs = array_column($myProjects,'project_id');

        $schedule = schedule;
        $project = Projects::select('project.id as id','project.project_title','project.project_type','project.project_image','project.save_type','project.created_at','users.name','users.lname','project.status')
         ->leftjoin('users','project.created_by', '=', 'users.id')
         ->whereIn('project.status',[1,2])
         ->orderBy('id','DESC');

        $project = $userData->user_type == 1 ? $project->get() : $project->whereIn('project.id',$myProjectIDs)->get();

        return view("assessment.create", ['projects' =>  $project , 'schedule' =>  $schedule]);
    }

    public function view(Request $request, $id){
        $assessment = Assessment::where('id', $id)->first();

        $questions = DB::table('question_bank')
        ->join('assessment_question', 'question_bank.id', '=', 'assessment_question.question_id')
        ->where('assessment_question.assessment_id', $id)
        ->select('question_bank.*')
        ->get();

        $projectImg = DB::table('project')
         ->join('project_assessment', 'project.id', '=' , 'project_assessment.project_id')
         ->where('project_assessment.assessment_id', $id)
         ->get();

        $userdata = DB::table('project_team')
        ->where('project_assessment.assessment_id', $id)
        ->join('users', 'project_team.user_id', '=' , 'users.id')
        ->join('project_assessment', 'project_team.project_id', '=' , 'project_assessment.project_id')
        ->get();

        return view("assessment.view" , ['assessment' => $assessment, 'questions' => $questions , 'project' => $projectImg], compact('userdata'));
    }

    public function inviteUser(Request $request, $id){
        $assessment = Assessment::where('id', $id)->first();

        // Below status should be 2 as 2 is for published and 3 is for completed according to the db.
        if($assessment->status != 2):
            return redirect()->route('assessment.view',['id' => $id])->with('error', 'Status not publish.');
        endif;

        $questions = DB::table('question_bank')
        ->join('assessment_question', 'question_bank.id', '=', 'assessment_question.question_id')
        ->where('assessment_question.assessment_id', $id)
        ->select('question_bank.*')
        ->get();

        $projectImg = DB::table('project')
         ->join('project_assessment', 'project.id', '=' , 'project_assessment.project_id')
         ->where('project_assessment.assessment_id', $id)
         ->get();

        $userdata = DB::table('project_team')
        ->where('project_assessment.assessment_id', $id)
        ->join('users', 'project_team.user_id', '=' , 'users.id')
        ->join('project_assessment', 'project_team.project_id', '=' , 'project_assessment.project_id')
        ->get();

        return view("assessment.invite" , ['assessment' => $assessment, 'questions' => $questions , 'project' => $projectImg], compact('userdata'));

    }


    public function preview(Request $request, $id){
        $assessment = Assessment::where('id', $id)->first();

        $questions = DB::table('question_bank')
        ->join('assessment_question', 'question_bank.id', '=', 'assessment_question.question_id')
        ->where('assessment_question.assessment_id', $id)
        ->select('question_bank.*')
        ->get();

        $projectImg = DB::table('project')
         ->join('project_assessment', 'project.id', '=' , 'project_assessment.project_id')
         ->where('project_assessment.assessment_id', $id)
         ->get();

        $userdata = DB::table('project_team')
        ->where('project_assessment.assessment_id', $id)
        ->join('users', 'project_team.user_id', '=' , 'users.id')
        ->join('project_assessment', 'project_team.project_id', '=' , 'project_assessment.project_id')
        ->get();

        return view("assessment.preview" , ['assessment' => $assessment, 'questions' => $questions , 'project' => $projectImg], compact('userdata'));
    }

    public function publish(Request $request, $id){
        $assessment  = Assessment::where('id' , $id)->first();
        $assessment->status = 2;
        $assessment->save();
        return response()->json(['success' => 'Assessment '. $assessment->title .' public successfully']);
    }

    public function complete(Request $request, $id){
        $assessment  = Assessment::where('id' , $id)->first();
        $assessment->status = 3;
        $assessment->save();
        return response()->json(['success' => 'Assessment '. $assessment->title .' completed successfully']);
    }

    public function edit($id){

        $userData = DB::table('users')->where('id',Session::get('user_id'))->first();

        $myProjects = ProjectTeam::where('user_id',Session::get('user_id'))->get('project_id');
        $myProjects = $myProjects ? $myProjects->toArray() : [];
        $myProjectIDs = array_column($myProjects,'project_id');

        $schedule = schedule;
        $questions = DB::table('question_bank')
        ->join('assessment_question', 'question_bank.id', '=', 'assessment_question.question_id')
        ->where('assessment_question.assessment_id', $id)
        ->select('question_bank.*')
        ->get();


        $projectList = Projects::select('project.id as id','project.project_title','project.project_type','project.project_image','project.save_type','project.created_at','users.name','users.lname','project.status')
        ->leftjoin('users','project.created_by', '=', 'users.id')
        ->whereIn('project.status',[1,2])
        ->orderBy('id','DESC');

        $projectList = $userData->user_type == 1 ? $projectList->get() : $projectList->whereIn('project.id',$myProjectIDs)->get();

        $project = DB::table('project')
        ->join('project_assessment', 'project.id', '=' , 'project_assessment.project_id')
        ->where('project_assessment.assessment_id', $id)
        ->get();

        $assessment = Assessment::where('id', $id)->first();
        return view("assessment.edit", ['assessment' => $assessment, 'schedule' => $schedule , 'questions' => $questions,'projectIds' => $project->toArray() , 'projects' =>  $projectList  ]);
    }

    public function questionBank(){
        return view("assessment.questionbank");
    }

    public function templates(){
        return view("assessment.template");
    }

    public function cloneAssessmentlist(Request $request){

        $schedule = schedule;
        $query = Assessment::query();


       if ($request->sdate) {
           $query->whereDate('created_at', '>=', $request->sdate);
       }

       if ($request->endDate) {
           $query->whereDate('created_at', '<=', $request->endDate);
       }

       if ($request->status) {
           $query->where('status', $request->status);
       }

       if($request->search){
           $query->where('title', "%{$request->search}%");
       }

       $assessments = $query->paginate(5);
        return view("assessment.clonelist" , ['assessments' => $assessments , 'schedule' => $schedule]);
    }

    public function cloneAssessmentForCreate(Request $request, $id){

        $userData = DB::table('users')->where('id',Session::get('user_id'))->first();

        $myProjects = ProjectTeam::where('user_id',Session::get('user_id'))->get('project_id');
        $myProjects = $myProjects ? $myProjects->toArray() : [];
        $myProjectIDs = array_column($myProjects,'project_id');

        $schedule = schedule;
        $project = Projects::select('project.id as id','project.project_title','project.project_type','project.project_image','project.save_type','project.created_at','users.name','users.lname','project.status')
                ->leftjoin('users','project.created_by', '=', 'users.id')
                ->whereIn('project.status',[1,2])
                ->orderBy('id','DESC');

        $project = $userData->user_type == 1 ? $project->get() : $project->whereIn('project.id',$myProjectIDs)->get();

        $assessmentbyid = DB::table('assessments')->where('id', $id)->first();

        // Get all questions associated with the assessment using join
        $questions = DB::table('question_bank')
        ->join('assessment_question', 'question_bank.id', '=', 'assessment_question.question_id')
        ->where('assessment_question.assessment_id', $id)
        ->select('question_bank.*')
        ->get();



        if (!$assessmentbyid) {
            return redirect()->back()->with('error', 'Assessment not found.');
        }

        return view("assessment.create", ['projects' =>  $project , 'schedule' =>  $schedule , 'questions' =>  $questions , 'assessment' => $assessmentbyid]);
    }

    public function delete($id)
    {
        $assessment = Assessment::findOrFail($id);
        $assessment->delete();
        return response()->json(['message' => 'Assessment deleted successfully']);
    }

    // Post methods
    public function assessmentCreate(Request $request){
        $request->validate([
            'title' => 'required|string|unique:assessments,title',
            'project_type' => 'required',
            'administration_schedule' => 'required',
            'description' => 'required',
        ]);




        // $assessment = new Assessment();
        // $assessment->title = $request->title;
        // $assessment->scoring = $request->scoring;
        // $assessment->project_type = $request->project_type;
        // $assessment->administration_schedule =  implode(',', $request->administration_schedule);
        // $assessment->description = $request->description;
        // $assessment->save();


        $assessment = Assessment::create([
            'title' => $request->title,
            'scoring' => $request->scoring,
            'project_type' => $request->project_type,
            'administration_schedule' => implode(',', $request->administration_schedule),
            'description' => $request->description
        ]);



        if( is_null($assessment) ):
            return response()->json(['error' => 'Something went wrong. Please try again.']);
        endif;


        $questions = $request->questions;
        if($request->questions){
            $questionId = array_column($questions, 'id');
            if($questionId[0] == 0){
                $titles = array_column($questions, 'title');
                $existingTitles = QuestionBank::whereIn('question_title', $titles)->first();
                $checkMapIds = is_null($existingTitles) ? null : AssessmentQuestion::where('assessment_id', $assessment->id )->where('question_id', $existingTitles->id)->first();

                    if ($checkMapIds) {
                        return response()->json([
                            'questiontitle' => 'Some question titles already exist in the database.',
                            'existing_titles' => $existingTitles->question_title
                        ], 422);
                    }
            }

        }


        $projectIds = explode(',', $request->projectinclude);
        foreach ($projectIds as $project_id) {
            ProjectAssessment::create([
                'assessment_id' => $assessment->id,
                'project_id' => $project_id,
                ]);
            }

        if($request->questions){
            foreach ($request->questions as $question) {
                if($question['id'] == 0){
                 // modify by sachin check question in already in question tem bank
                   if( isset($question['addQuestionBank']) && ($question['addQuestionBank'] == 'true')){
                       $checkAllreadyExitsBank =  QuestionBank::where('question_title' , $question['title'])->where('assessment_only', 1)->first();
                        if ($checkAllreadyExitsBank) {
                            return response()->json([
                                'questiontitle' => 'Some question titles already exist in item bank.',
                                'existing_titles' => $checkAllreadyExitsBank->question_title
                            ], 422);
                        }
                   }


                    if($question['qtype'] == 'singleType' ||  $question['qtype'] == 'multiType'){
                        $questionBank = QuestionBank::create([
                            'question_type' => $question['qtype'],
                            'question_title' => $question['title'],
                            'question_option1' => isset($question['optiontype'][0]) ? $question['optiontype'][0] : '',
                            'question_option2' => isset($question['optiontype'][1]) ? $question['optiontype'][1] : '',
                            'question_option3' => isset($question['optiontype'][2]) ? $question['optiontype'][2] : '',
                            'question_option4' => isset($question['optiontype'][3]) ? $question['optiontype'][3] : '',
                            'question_option5' => isset($question['optiontype'][4]) ? $question['optiontype'][4] : '',
                            'question_option6' => isset($question['optiontype'][5]) ? $question['optiontype'][5] : '',
                            'question_image' =>   isset($question['questionAudio']) ? $question['questionAudio']: '',
                            'question_video' =>   isset($question['questionVideo']) ? $question['questionVideo']: '',
                            'question_file' => '',
                            'question_guidlines' => isset($question['guideLines']) ? $question['guideLines'] : '',
                            'assessment_only' => isset($question['addQuestionBank']) && ($question['addQuestionBank'] == 'true') ?  true : false,
                            'score_required' => isset($question['scoringRequired']) ? $question['scoringRequired'] : '',
                            'score_type' =>  isset($question['scoreQuestionType']) ? $question['scoreQuestionType'] : '',
                            'score_option' => isset($question['qScore']) ? $question['qScore'] : '',
                            'status' => 1,
                            'question_require' => $question['required']
                        ]);

                    }else{

                        $questionBank = QuestionBank::create([
                            'question_type' => $question['qtype'],
                            'question_title' => $question['title'],
                            'question_option1' => isset($question['anstype']) ? $question['anstype'] : '',
                            'question_option2' => '',
                            'question_option3' => '',
                            'question_option4' => '',
                            'question_option5' => '',
                            'question_option6' => '',
                            'question_image' =>  isset($question['questionAudio']) ? $question['questionAudio']: '',
                            'question_video' =>  isset($question['questionVideo']) ? $question['questionVideo']: '' ,
                            'question_file' =>  isset($question['files']) ? $question['files'] : '',
                            'question_guidlines' => isset($question['guideLines']) ? $question['guideLines'] : '',
                            'assessment_only' => isset($question['addQuestionBank']) && ($question['addQuestionBank'] == 'true') ?  true : false,
                            'score_required' => isset($question['scoringRequired']) ? $question['scoringRequired'] : '',
                            'score_type' =>  isset($question['scoreQuestionType']) ? $question['scoreQuestionType'] : '',
                            'score_option' => isset($question['qScore']) ? $question['qScore'] : '',
                            'status' => 1 ,
                            'question_require' => $question['required']
                        ]);

                    }

                    AssessmentQuestion::create([
                        'assessment_id' => $assessment->id,
                        'question_id' => $questionBank->id,
                    ]);

                }else{
                    AssessmentQuestion::create([
                        'assessment_id' => $assessment->id,
                        'question_id' =>  $question['id']
                    ]);
                }

            }
        }

        if($assessment !=""){
            return response()->json(['success' => 'Assessment is successfully created.','redirect_url' => route('assessment.view', ['id' => $assessment->id])]);
        }

    }
    public function update(Request $request, $id){

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'project_type' => 'required',
            'administration_schedule' => 'required',
             'description' => 'required|string',
        ]);

        $assessment = Assessment::find($id);
        $assessment->update([
            'title' => $request->title,
            'project_type' => $request->project_type,
            "scoring" => $request->scoring,
            'administration_schedule' =>  implode(',', $request->administration_schedule),
            'description' => $request->description,
        ]);

        ProjectAssessment::where('assessment_id', $id)->delete();

        $projectIds = explode(',', $request->projectinclude);

        foreach ($projectIds as $project_id) {
            ProjectAssessment::create([
                'assessment_id' => $assessment->id,
                'project_id' => $project_id,
                ]);
            }


        AssessmentQuestion::where('assessment_id', $assessment->id)->delete();
      // dd($request->questions);
        if($request->questions){
            foreach ($request->questions as $question) {


                if(isset($question['id']) && !empty($question['id'] && $question['id'] > 0)){
                    if($question['qtype'] == 'singleType' ||  $question['qtype'] == 'multiType'){
                    $questionBank = QuestionBank::find($question['id']);
                    $questionBank->update([
                        'question_type' => $question['qtype'],
                        'question_title' => $question['title'],
                        'question_option1' => isset($question['optiontype'][0]) ? $question['optiontype'][0] : '',
                        'question_option2' => isset($question['optiontype'][1]) ? $question['optiontype'][1] : '',
                        'question_option3' => isset($question['optiontype'][2]) ? $question['optiontype'][2] : '',
                        'question_option4' => isset($question['optiontype'][3]) ? $question['optiontype'][3] : '',
                        'question_option5' => isset($question['optiontype'][4]) ? $question['optiontype'][4] : '',
                        'question_option6' => isset($question['optiontype'][5]) ? $question['optiontype'][5] : '',
                        'question_image' => isset($question['questionAudio']) ? $question['questionAudio']: '',
                        'question_video' => isset($question['questionVideo']) ? $question['questionVideo']: '',
                        'question_file' => '',
                        'question_guidlines' => '' ,
                        'assessment_only' =>  isset($question['addQuestionBank']) && ($question['addQuestionBank'] == 'true') ?  true : false,
                        'score_required' => isset($question['scoringRequired']) ? $question['scoringRequired'] : '',
                        'score_type' =>  isset($question['scoreQuestionType']) ? $question['scoreQuestionType'] : '',
                        'score_option' => isset($question['qScore']) ? $question['qScore'] : '',
                        'status' => 1,
                        'question_require' => $question['required']
                    ]);
                    }else{
                        $questionBank = QuestionBank::find($question['id']);
                        $questionBank->update([
                            'question_type' => $question['qtype'],
                            'question_title' => $question['title'],
                            'question_option1' => isset($question['anstype']) ? $question['anstype'] : '',
                            'question_option2' => '',
                            'question_option3' => '',
                            'question_option4' => '',
                            'question_option5' => '',
                            'question_option6' => '',
                            'question_image' => isset($question['questionAudio']) ? $question['questionAudio']: '',
                            'question_video' => isset($question['questionVideo']) ? $question['questionVideo']: '',
                            'question_file' =>  isset($question['files']) ? $question['files'] : '',
                            'question_guidlines' => isset($question['guideLines']) ? $question['guideLines'] : '',
                            'assessment_only' =>  isset($question['addQuestionBank']) && ($question['addQuestionBank'] == 'true') ?  true : false,
                            'score_required' => isset($question['scoringRequired']) ? $question['scoringRequired'] : '',
                            'score_type' =>  isset($question['scoreQuestionType']) ? $question['scoreQuestionType'] : '',
                            'score_option' => isset($question['qScore']) ? $question['qScore'] : '',
                            'status' => 1 ,
                            'question_require' => $question['required']
                        ]);

                    }
                }else{

                    // check duplicate question error

                        $titles = $question['title'];
                        $existingtitles = questionbank::where('question_title', $titles)->first();
                        $checkMapIds = is_null($existingtitles) ? null : AssessmentQuestion::where('assessment_id', $assessment->id )->where('question_id', $existingtitles->id)->first();

                        if ($checkMapIds) {
                                return response()->json([
                                    'questiontitle' => 'some question titles already exist in the database.',
                                    'existing_titles' => $existingtitles->question_title
                                ], 422);
                            }



                            // modify by sachin check question in already in question tem bank
                   if( isset($question['addQuestionBank']) && ($question['addQuestionBank'] == 'true')){
                        $checkAllreadyExitsBank =  QuestionBank::where('question_title' , $question['title'])->where('assessment_only', 1)->first();
                        if ($checkAllreadyExitsBank) {
                            return response()->json([
                                'questiontitle' => 'Some question titles already exist in item bank.',
                                'existing_titles' => $checkAllreadyExitsBank->question_title
                            ], 422);
                        }
                    }

                    if($question['qtype'] == 'singleType' &&  $question['qtype'] == 'multiType'){
                        $questionBank = QuestionBank::create([
                            'question_type' => $question['qtype'],
                            'question_title' => $question['title'],
                            'question_option1' => isset($question['optiontype'][0]) ? $question['optiontype'][0] : '',
                            'question_option2' => isset($question['optiontype'][1]) ? $question['optiontype'][1] : '',
                            'question_option3' => isset($question['optiontype'][2]) ? $question['optiontype'][2] : '',
                            'question_option4' => isset($question['optiontype'][3]) ? $question['optiontype'][3] : '',
                            'question_option5' => isset($question['optiontype'][4]) ? $question['optiontype'][4] : '',
                            'question_option6' => isset($question['optiontype'][5]) ? $question['optiontype'][5] : '',
                            'question_image' => isset($question['questionAudio']) ? $question['questionAudio']: '',
                            'question_video' => isset($question['questionVideo']) ? $question['questionVideo']: '',
                            'question_file' => '',
                            'question_guidlines' => '' ,
                            'assessment_only' => isset($question['addQuestionBank']) && ($question['addQuestionBank'] == 'true') ?  true : false,
                            'score_required' => isset($question['scoringRequired']) ? $question['scoringRequired'] : '',
                            'score_type' =>  isset($question['scoreQuestionType']) ? $question['scoreQuestionType'] : '',
                            'score_option' => isset($question['qScore']) ? $question['qScore'] : '',
                            'status' => 1,
                            'question_require' => $question['required']
                          ]);
                        }else{

                            $questionBank = QuestionBank::create([
                                'question_type' => $question['qtype'],
                                'question_title' => $question['title'],
                                'question_option1' => isset($question['anstype']) ? $question['anstype'] : '',
                                'question_option2' => '',
                                'question_option3' => '',
                                'question_option4' => '',
                                'question_option5' => '',
                                'question_option6' => '',
                                'question_image' => isset($question['questionAudio']) ? $question['questionAudio']: '',
                                'question_video' => isset($question['questionVideo']) ? $question['questionVideo']: '',
                                'question_file' =>  isset($question['files']) ? $question['files'] : '',
                                'question_guidlines' => isset($question['guideLines']) ? $question['guideLines'] : '',
                                'assessment_only' => isset($question['addQuestionBank']) && ($question['addQuestionBank'] == 'true') ?  true : false,
                                'score_required' => isset($question['scoringRequired']) ? $question['scoringRequired'] : '',
                                'score_type' =>  isset($question['scoreQuestionType']) ? $question['scoreQuestionType'] : '',
                                'score_option' => isset($question['qScore']) ? $question['qScore'] : '',
                                'status' => 1 ,
                                'question_require' => $question['required']
                              ]);

                        }
                }

                AssessmentQuestion::create([
                    'assessment_id' => $assessment->id,
                    'question_id' => $questionBank->id,
                ]);

            }
        }

        if($assessment !=""){
            return response()->json(['success' => 'Assessment is successfully updated.']);
        }

    }

    public function selectFromQuestionBank(Request  $request){
        $questionBank = QuestionBank::query()
        ->where('assessment_only' , 1)
        ->orderBy('id','desc')
        ->paginate(5);

        if(!empty($questionBank)){
            return response()->json(['questionBank' => $questionBank]);
        }else{
            return response()->json(['message' => 'Question not found']);
        }

    }

    public function upload(Request $request){
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->file('image')->isValid()) {
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move('assets/uploads/question/',$imageName);
            return response()->json(['message' => 'Image uploaded successfully.', 'image' => $imageName]);
        }
    }
}

