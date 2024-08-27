<?php

namespace App\Http\Controllers;
use App\Models\AssessmentIntives;
use App\Models\Assessment;
use App\Models\InvitesCandidates;
use App\Models\AssessmentAttempts;
use App\Models\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\View;

use App\Mail\InviteUser;
use Session;


class InviteConroller extends Controller
{
    public function index(Request $request){
        $assessmentid = (int)  $request->id ;
        // Query to fetch assessmentName
        $assessmentRecord = Assessment::where('id', $assessmentid)->first();

        $usr_id = Session::get('user_id');
        // Query to fetch User name
        $userRecord = User::where('id', $usr_id)->first();

        // To capture user's input in the body
        $userInput = $request->send_invite;
        // var_dump($userInput);

        $emailArray = explode(',', $request->email);

        if($emailArray && is_array($emailArray)):
            foreach ($emailArray as $email) :

                $email = trim($email);

                if( empty($email) ):
                    continue;
                endif;

                $candidates = InvitesCandidates::where('email', $email)->first();

                if(empty($candidates)):

                    $candidates = InvitesCandidates::create([
                            "first_name" => "",
                            "last_name" => "",
                            "email" => $email,
                    ]);

                endif;

                $assessmentintives = AssessmentIntives::where('candidate_id',  $candidates->id)
                ->where('assessment_id', $assessmentid)
                ->first();



                if($assessmentintives == null):
                    // dd($assessmentintives);
                    $user_id = Session::get('user_id');
                    $hrtime = hrtime(true);
                    $hrtimeString = (string)$hrtime;
                    $token = md5($candidates->id . $hrtimeString);

                    $assessmentintives =  AssessmentIntives::create([
                                "candidate_id" => $candidates->id,
                                "assessment_id" => $request->id,
                                "invite_code" => $token,
                                "invited_by" => $user_id,
                                'invitation_type' => 'email'
                    ]);

                endif;

                Mail::to($candidates->email)->send( new InviteUser($assessmentintives, $assessmentRecord, $userRecord, $userInput));

            endforeach;
        endif;


        return response()->json([
            'message' => 'Invitations sent successfully!'
        ]);

    }

    public function sendInfo() {
        $user_id = Session::get('user_id');
        $assessment_id = Session::get('assessment_id');
        $user = User::find($user_id);
        return view('emails.invite', ['assessmentName' => $assessment_id, 'userName' => $user->first_name]);
    }

    public function inviteEmailUrl(Request $request, $token){
        return view("invite.inviteemail", ['token' => $token]);
    }

    public function inviteUrl(Request $request, $token,$invitedBy=''){
        // Check if the token is numeric or alphanumeric
        if (is_numeric($token)) {
            // If the token is numeric/integer, fetch the record based on the numeric value
            $assessment = Assessment::with('assessmentProjectId')->where('id', $token)->first();
        } else {
            $assessmentData = AssessmentIntives::where('invite_code', $token)->first();

            if(empty($assessmentData)):
                abort(404);
            endif;

            $assessment = Assessment::with('assessmentProjectId')->where('id', $assessmentData->assessment_id)->first();
        }

        // Handle the case where no assessment is found
        if (empty($assessment)) {
            abort(404);
        }

        $userdata = DB::table('project_team')
        ->where('project_assessment.assessment_id', $assessment->id)
        ->join('users', 'project_team.user_id', '=' , 'users.id')
        ->join('project_assessment', 'project_team.project_id', '=' , 'project_assessment.project_id')
        ->first();

        return view("invite.invite" ,['assessment' =>  $assessment, 'teammanager' => $userdata, 'token' => $token]);

    }

   public function startTest(Request $request, $token){
        // Check if the token is numeric or alphanumeric
        if (is_numeric($token)) {
            $assessmentData = AssessmentIntives::where('assessment_id', $token)
            ->join('candidates', 'assessment_invites.candidate_id', '=' , 'candidates.id')
            ->first();
        } else {
            $assessmentData = AssessmentIntives::where('invite_code', $token)
            ->join('candidates', 'assessment_invites.candidate_id', '=' , 'candidates.id')
            ->first();
        }

        if(empty($assessmentData)):
            abort(404);
        endif;

        // If the token is a number, that is, it was sent as a generated link, then the Email prompt should be displayed as well
        if (is_numeric($token)) {
            if(empty($assessmentData->email)):
                return redirect()->back()->with('userId', $assessmentData->candidate_id)->with('usrinfo','Email is missing.');
            endif;
        }

        // Should below condition be || ?
        if(empty($assessmentData->first_name) || empty($assessmentData->last_name)):
            return redirect()->back()->with('userId', $assessmentData->candidate_id)->with('usrinfo','User Info is missing.');
        endif;

        $assessment = Assessment::where('id',  $assessmentData->assessment_id)->first();

        $questions = DB::table('question_bank')
        ->join('assessment_question', 'question_bank.id', '=', 'assessment_question.question_id')
        ->where('assessment_question.assessment_id', $assessmentData->assessment_id)
        ->select('question_bank.*')
        ->get();

        $projectImg = DB::table('project')
         ->join('project_assessment', 'project.id', '=' , 'project_assessment.project_id')
         ->where('project_assessment.assessment_id', $assessmentData->assessment_id)
         ->get();

        $userdata = DB::table('project_team')
        ->where('project_assessment.assessment_id', $assessmentData->assessment_id)
        ->join('users', 'project_team.user_id', '=' , 'users.id')
        ->join('project_assessment', 'project_team.project_id', '=' , 'project_assessment.project_id')
        ->get();

        return view("invite.starttest" , ['assessment' => $assessment, 'questions' => $questions , 'project' => $projectImg, 'assessmentData' => $assessmentData], compact('userdata'));

   }

    /**
     * This function will handle Token
     */
    public function handleToken(Request $request, $token, $invitedBy='') {

        if(is_numeric($token)) {
            $assessment = Assessment::with('assessmentProjectId')->where('id', $token)->first();
            return view('invite.email_prompt', ['token' => $token,'invitedBy'=>$invitedBy]);
            // return view('invite.invite');
        } else {
            // Fetch the record with associated unique token (alphanumeric).
            // Find the candidate/user with that record.
            // Check if its first,last names are empty and if so ask for its values else return view (test)
            $assessmentData = AssessmentIntives::where('invite_code', $token)->first();

            if(empty($assessmentData)):
                abort(404);
            endif;

            $assessment = Assessment::with('assessmentProjectId')->where('id', $assessmentData->assessment_id)->first();

            // Handle the case where no assessment is found
            if (empty($assessment)) {
                abort(404);
            }

            $candidate = DB::table('candidates')
            ->join('assessment_invites', 'candidates.id', '=', 'assessment_invites.candidate_id')
            ->where('assessment_invites.invite_code', $token)
            ->select('candidates.*')
            ->first();

            $userdata = DB::table('project_team')
            ->where('project_assessment.assessment_id', $assessment->id)
            ->join('users', 'project_team.user_id', '=' , 'users.id')
            ->join('project_assessment', 'project_team.project_id', '=' , 'project_assessment.project_id')
            ->first();

            if (empty($candidate->first_name) || empty($candidate->last_name)) {
                // return view to ask to enter names
                // $email = $candidate->email;
                return view("invite.invite", ['email' => $candidate->email, 'token' => $token]);
            } else {
                // invite.test
                return view("invite.test_page", ['token' => $token, 'assessment' => $assessment, 'teammanager' => $userdata]);
                // return redirect()->route('invite.test', $token)->with('status', 'User updated successfully.');
            }
        }
    }

    public function checkEmail(Request $request) {
        // dd($request->input());
        $email = $request->input('email');
        $token = $request->input('token');
        $invitedBy = $request->input('invitedBy');

        $request->validate([
            'email' => ['required', 'email', 'regex:/^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/'],
        ]);

        // check if the email exists
        $exists = InvitesCandidates::where('email', $email)->exists();

        if( !$exists ):
            InvitesCandidates::create([
                'email' => $email,
                'first_name' => '',
                'last_name' => ''
            ]);
        endif;

        $candidate = InvitesCandidates::where('email', $email)->first();

        // check for already invited.
        $alreadyInvitedCheck = AssessmentIntives::where('assessment_id',$token)->where('candidate_id',$candidate->id)->first();
        // $alreadyInvitedCheck = $alreadyInvitedCheck ? $alreadyInvitedCheck->toArray() : [];

        if( is_null($alreadyInvitedCheck) ):
            $user_id = $invitedBy;
            $hrtime = hrtime(true);
            $hrtimeString = (string)$hrtime;
            $newtoken = md5($candidate->id . $hrtimeString);

            $alreadyInvitedCheck =  AssessmentIntives::create([
                        "candidate_id" => $candidate->id,
                        "assessment_id" => $token,
                        "invite_code" => $newtoken,
                        "invited_by" => $user_id,
                        'invitation_type' => 'link'
            ]);
        endif;

        return redirect()->route('invite.inviteusercall',['token'=>$alreadyInvitedCheck->invite_code]);
    }

        // If email exists in the database table candidates
        // if($exists) {
        //     // check if this record has first and last name already
        //     $candidate = InvitesCandidates::where('email', $email)->first();

        //     if (empty($candidate->first_name) || empty($candidate->last_name)) {
        //         // return view to ask to enter names
        //         return view("invite.invite", ['email' => $email, 'token' => $token]);
        //     } else {
        //         // invite.test
        //         $assessmentData = AssessmentIntives::where('invite_code', $token)->first();

        //         if(empty($assessmentData)):
        //             abort(404);
        //         endif;

        //         $assessment = Assessment::with('assessmentProjectId')->where('id', $assessmentData->assessment_id)->first();

        //         // Handle the case where no assessment is found
        //         if (empty($assessment)) {
        //             abort(404);
        //         }

        //         $userdata = DB::table('project_team')
        //         ->where('project_assessment.assessment_id', $assessment->id)
        //         ->join('users', 'project_team.user_id', '=' , 'users.id')
        //         ->join('project_assessment', 'project_team.project_id', '=' , 'project_assessment.project_id')
        //         ->first();

        //         return view("invite.test_page", ['token' => $token, 'assessment' => $assessment, 'teammanager' => $userdata]);
        //         // return redirect()->route('invite.test', $token)->with('status', 'User updated successfully.');
        //     }

        // } else {
        //     // create a record with an email and empty f,l name
        //     InvitesCandidates::create([
        //         'email' => $email,
        //         'first_name' => '',
        //         'last_name' => ''
        //     ]);
        //     // then return the view to ask for first and last name

        //     return view("invite.invite", ['email' => $email, 'token' => $token]);
        // }
    
    public function checkName(Request $request) {
        $email = $request->input('email');
        $firstName = $request->input('first_name');
        $lastName = $request->input('last_name');
        $token = $request->input('token');
        
        // $rules = [
        //     'name' => 'required|string|max:255',
        //     'lname' => 'required|string|max:255',
        // ];

        // $validator = Validator::make($request->all(), $rules);

        // if ($validator->fails()) :
            // return redirect()->back()->withErrors($validator)->withInput();
        // return redirect()->route('invite.inviteusercall',['token' => $request->token])->with('userId', $request->candidates)->with('usrinfo','First name and/or Last name is not valid.')->withErrors($validator)->withInput();
        // endif;


        // Process the data
        // Update a record with this email.
        $candidate = InvitesCandidates::where('email', $email)->first();
        if ($candidate) {
            $candidate->first_name = $firstName;
            $candidate->last_name = $lastName;
            $candidate->save();
        } else {
            return redirect()->back();
        }

        if (is_numeric($token)) {
            $assessmentData = AssessmentIntives::where('assessment_id', $token)->first();
        } else {
            $assessmentData = AssessmentIntives::where('invite_code', $token)->first();
        }
        // $assessmentData = AssessmentIntives::where('invite_code', $token)->first();

        if(empty($assessmentData)):
            abort(404);
        endif;

        $assessment = Assessment::with('assessmentProjectId')->where('id', $assessmentData->assessment_id)->first();

        // Handle the case where no assessment is found
        if (empty($assessment)) {
            abort(404);
        }

        $userdata = DB::table('project_team')
        ->where('project_assessment.assessment_id', $assessment->id)
        ->join('users', 'project_team.user_id', '=' , 'users.id')
        ->join('project_assessment', 'project_team.project_id', '=' , 'project_assessment.project_id')
        ->first();

        return redirect()->route('invite.inviteusercall',['token'=>$token]);

        // After saving it, return view start test
        // return view("invite.test_page", ['token' => $token, 'assessment' => $assessment, 'teammanager' => $userdata]);
        // return redirect()->route('invite.test', $token)->with('status', 'User updated successfully.');
    }

//     public function insertUserDetails( Request $request){

//          $rules = [
//             'name' => 'required|string|max:255',
//             'lname' => 'required|string|max:255',
//           ];

//           $validator = Validator::make($request->all(), $rules);

//           if ($validator->fails()) :
//             return redirect()->route('invite.inviteusercall',['token' => $request->token])->with('userId', $request->candidates)->with('usrinfo','First name and/or Last name is empty.')->withErrors($validator)->withInput();
//           endif;

//          $candidates =  InvitesCandidates::where("id", $request->candidates)->first();

//          $candidates->update([
//             'first_name' => $request->name,
//             'last_name' => $request->lname,
//            ]);

//         // return view("invite.test_page", ['token' => $token, 'assessment' => $assessment, 'teammanager' => $userdata]);
//         return redirect()->route('invite.test', $request->token)->with('status', 'User updated successfully.');
//    }

   // for save details
   public function assessmentAttempts( Request $request){
        $assessment_id = $request->assessment_id;
        // $assessment_name = DB::table('assessments')
        // ->where('id', $assessment_id)
        // ->value('title');
        
        if($request->answerArray){
                foreach ($request->answerArray as $answer) {
              $attempted  = AssessmentAttempts::create([
                            "candidate_id" =>  $request->candidate_id,
                            "assessment_id" => $request->assessment_id,
                            "question_id" => $answer['id'],
                            "answer1" =>$answer['answer'],
                            "answer2" => '',
                            "given_score" => '',
                        ]);
                }
            if($attempted){
                return response()->json(['success' => 'Assessment attempted is successfully.', 'redirect_url' => route('invite.thankyou')]);
            }else{
                return response()->json(['success' => 'Assessment attempted is error.']);
            }
        } else {
            // return redirect()->route('thankyou');
            return response()->json(['success' => 'Assessment attempted is successfully.', 'redirect_url' => route('invite.thankyou')]);
        }
   }

    public function thankyou(){
        return view('invite.thankyou');
    }
}
