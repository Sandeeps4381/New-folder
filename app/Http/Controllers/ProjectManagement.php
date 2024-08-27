<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Validated;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\Console\Input\Input;
use App\Models\Projects;
use App\Models\Assessment;
use App\Models\ProjectAssessment;
use App\Models\User;
use App\Models\ProjectTeam;
use App\Models\UserRole;
use Session;


class ProjectManagement extends Controller
{

    // Update : Sandeep Kr, 25/07/2024 : fix search issue
    public function search(Request $request){
        $q = str_replace('+', ' ', $request->q);
        $project = DB::table('project')
        ->where('project_title', 'like', "%{$request->q}%")
        ->get();
        return response()->json($project);
    }


    public function index(Request $request){


        $projectList =  Projects::select('project.id as id','project.project_title')
        ->leftjoin('users','project.created_by', '=', 'users.id')
        ->where('project.status','!=',0)
        ->get();

        $user_id = Session::get('user_id');
        $userData = DB::table('users')->where('id' , $user_id)->first();
        $query = Projects::query();
        $query->leftjoin('users','project.created_by', '=', 'users.id');
        $query->select('project.id as id','project.project_title','project.project_type','project.project_image','project.save_type','project.created_at','users.name','users.lname','project.status');
        $query->where('project.status','!=',0);

        if($request->pro_id){
            $query->where('project.id','=',$request->pro_id);
        }
        if($request->prostatus){
            $query->where('project.status','=',$request->prostatus);
        }
        if($request->search){
            $query->where('project.project_title','like',"%{$request->search}%");
        }
        if($request->startDate){
            $start_date = date("Y-m-d",strtotime($request->startDate));
            $end_date = date('Y-m-d', strtotime($request->endDate));
            $query->whereDate('project.created_at', '>=', $start_date);
            $query->whereDate('project.created_at', '<=', $end_date);
        }



        if($userData->user_type != 1){
               $assignProjectid = DB::table('project_team')->where('user_id' , $user_id)->get();
               $ids = array_column($assignProjectid->toArray() , 'project_id');
               $query->whereIn('project.id', $ids);
        }

        $projectData = $query->orderBy('id','DESC')->paginate(5);
        return view("project.index",['currentUserType'=>$userData->user_type],compact('projectData','projectList'));
    }

    public function create(){
        return view("project.create");
    }
    public function saveProject(Request $request){
      // dd($request);
      $validator =  Validator::make($request->all(),[
                'project_title' => 'required',
                'project_type' => 'required',
                'project_description' => 'required',
                'project_image' => 'image|mimes:jpeg,png,jpg,svg', //|max:2048
                'project_guideline' => 'required',
                'status' => 'required',

            ],
            [
                'project_title.required'=> 'Project title is required', // custom message
                'project_type.required'=> 'Project type is required', // custom message
                'project_description.required'=> 'Project description is required', // custom message
                'project_guideline.required'=> 'Project guidelines is required', // custom message
                'project_image.required'=> 'Project image is required', // custom message
                'project_image.image'=> 'Should be image', // custom message
                'project_image.mimes'=> 'Image type should be jpeg,png,jpg, and svg', // custom message
            ]

        );
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput($request->all());
          }else{
            // upload imafge path
            // check same project title
            $user_id = Session::get('user_id');
            $alreadySameTitle = Projects::where('project_title','=',$request->project_title)->get();
            if(!empty($alreadySameTitle[0]) && $alreadySameTitle['0']->project_title!=''){
                return redirect()->back()->with('error', 'Same project title is already created.');
            }
            $file = $request->file('project_image');
            $originalName = str_replace(" ","-",$file->getClientOriginalName());
            $image = time().'_'. $originalName;
            $destinationPath = public_path('assets/uploads/projects/');
            $file->move($destinationPath,$image);

            $project = new Projects();
            $project->project_title = $request->project_title;
            $project->project_type = $request->project_type;
            $project->project_image = $image;
            $project->project_description = $request->project_description;
            $project->project_guideline = $request->project_guideline;
            $project->created_by = $user_id;
            $project->status = $request->project_create_type;
            $result = $project->save();
            $projectId = $project->id;

            if( $project ):
                $projectTeam = new ProjectTeam();
                $projectTeam->project_id = $projectId;
                $projectTeam->user_id = $user_id;
                $projectTeam->ismanger = 1;
                $projectTeam->save();
            endif;

            return redirect()->back()->with(array("success"=>"The project has been created." , 'projectid' => $project->id));
          }
    }

    public function view(Request $request){
        $project_id = $request->id;
        $user_id = Session::get('user_id');
        if($project_id!=''){
            $projDetails = Projects::where('id','=',$project_id )->get();
        }

        $assessments = DB::table('assessments')
        ->join('project_assessment', 'assessments.id', '=', 'project_assessment.assessment_id')
        ->join('project', 'project.id', '=', 'project_assessment.project_id')
        ->where('project_assessment.project_id', $project_id)
        ->select('assessments.*', 'assessments.status as assessment_status', 'assessments.id as assessment_id', 'project.*') // Select all columns from assessments and alias the status column
        ->paginate(5);

        $actionMode='NA';
        //dd($assessment->toArray());
        return view("project.view",compact('projDetails'), compact('assessments'));
    }

    public function unlinkAssessment(Request $request){
        $assessmentid = $request->id;
        $projectid = $request->projectid;

        $delete = DB::table('project_assessment')
                ->where('assessment_id', $assessmentid)
                ->where('project_id', $projectid)
                ->delete();

        if ($delete) {
            return response()->json(['message' => 'Assessment unlink successfully.']);
        } else {
            return response()->json(['message' => 'Assessment  link not found.'], 404);
        }

    }

    public function edit(Request $request){
        $prject_id = $request->id;
        $user_id = Session::get('user_id');
        if($prject_id!=''){
            $projDetails = Projects::where('id','=',$prject_id )->get();
        }

        return view("project.edit",compact('projDetails'));
    }
    // update project
    public function updateProject(Request $request){

        $validator =  Validator::make($request->all(),[
                'project_title' => 'required',
                'project_type' => 'required',
                'project_description' => 'required',
                'project_image' => 'image|mimes:jpeg,png,jpg,svg', //|max:2048
                'project_guideline' => 'required',

            ],
            [
                'project_title.required'=> 'Project title is required', // custom message
                'project_type.required'=> 'Project type is required', // custom message
                'project_description.required'=> 'Project description is required', // custom message
                'project_guideline.required'=> 'Project guidelines is required', // custom message
            ]

        );


       // dd($request->all());
        if ($validator->fails()) {
           // echo "hdh";exit;
            return redirect()->back()->withErrors($validator)->withInput($request->all());
        }else{
            // upload imafge path
            // check same project title
           // echo "else";exit;
            $user_id = Session::get('user_id');
            $alreadySameTitle = Projects::where('project_title','=',$request->project_title)->where('id','!=',$request->project_id)->get();
            if(!empty($alreadySameTitle[0]) && $alreadySameTitle['0']->project_title!=''){
                return redirect()->back()->with('error', 'Same project title is already created.');
            }



            if($request->hasFile('project_image')){
                $file = $request->file('project_image');
                $originalName = str_replace(" ","-",$file->getClientOriginalName());
                $image = time().'_'. $originalName;
                $destinationPath = public_path('assets/uploads/projects/');
                $file->move($destinationPath,$image);
            }

            //for check image exits or not
            $productImage =  Projects::where('id', $request->project_id)->first();

            if($request->imageremove == 1){
                Projects::where('id', $request->project_id)->update(array(
                    'project_title' => $request->project_title,
                    'project_type'=>$request->project_type,
                    'project_image'=> "",
                    'project_description'=>$request->project_description,
                    'project_guideline'=>$request->project_guideline,
                    'status '=> $request->project_create_type
                ));

            }else{

                if($productImage->project_image !="" && $request->file('project_image') == null){
                    Projects::where('id', $request->project_id)->update(array(
                        'project_title' => $request->project_title,
                        'project_type'=>$request->project_type,
                        'project_description'=>$request->project_description,
                        'project_guideline'=>$request->project_guideline,
                        'status '=> $request->project_create_type
                    ));
                }else{
                    Projects::where('id', $request->project_id)->update(array(
                        'project_title' => $request->project_title,
                        'project_type'=>$request->project_type,
                        'project_image'=>$image,
                        'project_description'=>$request->project_description,
                        'project_guideline'=>$request->project_guideline,
                        'status '=> $request->project_create_type
                    ));

                }
            }

            return redirect()->back()->with(array("success"=>"The project has been updated."));
        }
    }
    // delete project
    public function delete(Request $request){
        $id = $request->id;
        $projectData = Projects::find($id);
        if(isset($projectData['id']) && $projectData['id']!=''){
            Projects::where('id','=',$id)->update(array('status'=>0));
        }
        return response()->json(['message' => 'Project deleted successfully']);
    }

    public function projectTeamList(Request $request){

        $projectTeamUser = ProjectTeam::with(['userDetail'])->where('project_id',$request->project_id)->get();
        $projectTeamUser = $projectTeamUser ? $projectTeamUser->toArray() : [];

        return response()->json(['users' => $projectTeamUser], 200);

    }

    public function projectTeamCreate(Request $request){

        $projectDuplicate  = ProjectTeam::where('user_id', $request->user_id)
        ->where('project_id', $request->project_id)->first();


        if(!empty($projectDuplicate)){
            return response()->json(['message' => 'User already added', 'id' => $projectDuplicate->user_id] , 201);

        }else{
            $project = new ProjectTeam();
            $project->project_id = $request->project_id;
            $project->user_id = $request->user_id;
            $project->ismanger = $request->ismanger;
            $project->save();
            return response()->json($project, 201);
        }

    }

    public function projectTeam(Request $request)
    {

        ProjectTeam::where('project_id', $request->project_id)
        ->update(array(
            'ismanger'=> 0,
        ));


        $project = ProjectTeam::where('user_id', $request->user_id)
        ->where('project_id', $request->project_id)
        ->update(array(
            'project_id' => $request->project_id,
            'user_id'=>$request->user_id,
            'ismanger'=> 1,
        ));

        return response()->json($project, 201);

    }

    public function teamDelete(Request $request)
    {

         // Delete records based on user_id and product_id
         $deletedRows = ProjectTeam::where('user_id', $request->user_id)
         ->where('project_id', $request->project_id)
         ->delete();

        return response()->json(['deleted_rows' => $deletedRows], 200);
    }

}
