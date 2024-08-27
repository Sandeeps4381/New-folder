<?php

namespace App\Http\Controllers;

use App\Models\UserModel;
use App\Models\Assessment;
use App\Models\User;
use App\Models\Projects;
use App\Models\ProjectAssessment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Session;

class DashbordController extends Controller
{
    public function index(Request $request){
        $assessmentName = $request->input("assessment_name");
        $query = UserModel::query() 
        ->join('assessments', 'assessment_invites.assessment_id', '=', 'assessments.id') 
        -> select('assessments.title', 'assessments.title as assessment_name');

        $user_id = Session::get('user_id');
        $userData = DB::table('users')->where('id' , $user_id)->first();


        if ($request->has('start_date') && $request->has('end_date')) {
            
            $query->whereBetween('assessment_invites.created_at', [$request->start_date, $request->end_date]);
        }
        
        if ($assessmentName) {
            $query -> where('assessments.title', $assessmentName);
        }

        $rolesData = $query->get();
        $assessments = Assessment::pluck('title', 'id');
        $users = User::all();
        $projects = Projects::all();
       
        $recentProjects = DB::table('project')
        ->select('id', 'project_title', 'project_type', 'created_at')
        ->orderBy('created_at', 'desc')
        ->limit(5);

        if($userData->user_type != 1){
            $assignProjectid = DB::table('project_team')->where('user_id' , $user_id)->get();
            $ids = array_column($assignProjectid->toArray() , 'project_id');
            $recentProjects->whereIn('project.id', $ids);
        }

        $recentProjects = $recentProjects->get();

        $recentProjectIds = $recentProjects->pluck('id');

        $totalAssessments = DB::table('project_assessment')
        ->select('project_id', DB::raw('COUNT(*) as total_assessments'))
        ->whereIn('project_id', $recentProjectIds)
        ->groupBy('project_id')
        ->get()
        ->keyBy('project_id');

        $projectsWithManagers = DB::table('project_team')
        ->whereIn('project_id', $recentProjectIds)
        ->where('ismanger', 1)
        ->join('users', 'project_team.user_id', '=', 'users.id')
        ->select('project_team.project_id', 'users.name as manager_name')
        ->get()
        ->keyBy('project_id');
        
        $managers = $recentProjects->map(function($project) use ($recentProjects, $totalAssessments, $projectsWithManagers) {
            return [
                'identity' => $project->id,
                'title' => $project->project_title,
                'type' => $project->project_type,
                'date' => $project->created_at,
                'total_assessments' => $totalAssessments->get($project->id)->total_assessments ?? 0,
                'manager_name' => $projectsWithManagers->get($project->id)->manager_name ?? 'No Manager'
                
            ];
        });

        return view('dashboard/dashboard', ['rolesData' => $rolesData, 'assessments' => $assessments,
                                            'users' => $users, 'projects' => $projects,                                   
                                            'total_assessments' => $totalAssessments,
                                            'managers' => $managers]);
    }        
}