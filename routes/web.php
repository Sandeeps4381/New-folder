<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserManagement;
use App\Http\Controllers\ProjectManagement;
use App\Http\Controllers\ScoreController;
use App\Http\Controllers\AssessmentController;
use App\Http\Controllers\DashbordController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\InviteConroller;
use Illuminate\Support\Facades\Mail;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::controller(UserController::class)->group(function(){
    Route::get('/', 'index')->name('login');
    Route::get('registration', 'registration')->name('registration');
    Route::post('validate_registration', 'validate_registration')->name('user.validate_registration');
    Route::post('validate_login', 'validate_login')->name('user.validate_login');
    Route::get('/forgetpassword', [UserController::class, 'forgetPassword'])->name('users.forgetpassword');
    Route::get('/resetpassword/{token}', [UserController::class, 'resetPassword'])->name('users.resetpassword');
    Route::post('/forgetpasswordsend', [UserController::class, 'forgetpasswordsend']);
    Route::post('/resetpassword', [UserController::class, 'passwordReset'])->name('users.resetpassword.post');
    Route::get('logout', 'logout')->name('logout');

});

// User Management
Route::controller(UserManagement::class)->group(function(){
    Route::get('user/list', 'index')->name('user.list');
    Route::get('user/create', 'create')->name('user.create');
    Route::get('user/edit/{id}','edit')->name('user.edit');
    Route::get('user/view/{id}', 'view')->name('user.view');
    Route::post('user/update/{id}', 'update')->name('user.update');
    Route::post('user/save', 'save')->name('user.save');
    Route::get('user/status', 'status')->name('user.status');
    Route::get('user/create-role', 'createRole')->name('user.create-role');
    Route::post('user/saverole', 'postUserRole')->name('user.saverole');
    Route::get('user/list-role', 'listRoles')->name('user.list-role');
    Route::get('user/ajax-list-role', 'ajaxListRoles')->name('user.ajax-list-role');
    Route::get('user/edit-role/{id}', 'editRole')->name('user.edit-role');
    Route::post('user/save-editrole', 'editUserRole')->name('user.save-editrole');
    Route::get('role/status', 'roleStatus')->name('user.rolestatus');
    Route::get('user/view/role/{id}', 'viewRole')->name('user.viewrole');
    Route::post('user/search','search')->name('user.search');

});

// Project Management
Route::controller(ProjectManagement::class)->group(function(){
    Route::get('project/list', 'index')->name('project.list')->middleware('auth');
    Route::get('project/create', 'create')->name('project.create')->middleware('auth');
    Route::post('project/save', 'saveProject')->name('project.save')->middleware('auth');
    Route::get('project/view', 'view')->name('project.view')->middleware('auth');
    Route::get('project/edit', 'edit')->name('project.edit')->middleware('auth');
    Route::post('project/editsave', 'updateProject')->name('project.editsave')->middleware('auth');
    Route::post('project/delete', 'delete')->name('project.delete')->middleware('auth');
    Route::post('project/create', 'projectTeamCreate')->name('project.create')->middleware('auth');
    Route::post('project/team', 'projectTeam')->name('project.team')->middleware('auth');
    Route::post('project/teamdelete', 'teamDelete')->name('project.teamdelete')->middleware('auth');
    Route::post('project/teamlist', 'projectTeamList')->name('project.teamlist')->middleware('auth');
    Route::post('project/search', 'search')->name('project.search')->middleware('auth');
    Route::post('project/unlink', 'unlinkAssessment')->name('project.unlink')->middleware('auth');
});

// Assessment Management
Route::controller(AssessmentController::class)->group(function(){
    Route::get('assessment/list/{actionMode?}', 'index')->name('assessment.list')->middleware('auth');
    Route::get('assessment/create', 'create')->name('assessment.create')->middleware('auth');
    Route::get('assessment/view/{id}', 'view')->name('assessment.view')->middleware('auth');
    Route::get('assessment/preview/{id}', 'preview')->name('assessment.preview')->middleware('auth');
    Route::get('assessment/edit/{id}', 'edit')->name('assessment.edit')->middleware('auth');
    Route::get('assessment/questionbank', 'questionBank')->name('assessment.questionbank')->middleware('auth');
    Route::get('assessment/template', 'templates')->name('assessment.template')->middleware('auth');
    Route::post('assessment/save', 'assessmentCreate')->name('assessment.save')->middleware('auth');
    Route::post('assessment/delete/{id}', 'delete')->name('assessment.delete')->middleware('auth');
    Route::post('assessment/publish/{id}', 'publish')->name('assessment.publish')->middleware('auth');
    Route::post('assessment/complete/{id}', 'complete')->name('assessment.complete')->middleware('auth');
    Route::get('assessment/inviteuser/{id}', 'inviteUser')->name('assessment.inviteuser')->middleware('auth');
    Route::post('assessment/update/{id}', 'update')->name('assessment.update')->middleware('auth');
    Route::get('selectquestionbank', 'selectFromQuestionBank')->name('selectquestionbank')->middleware('auth');
    Route::get('assessment/list/clone', 'index')->name('assessmentclonelist')->middleware('auth');
    Route::post('uploadimage', 'upload')->name('uploadimage')->middleware('auth');
    Route::get('clone/assessmentclone/{id}', 'cloneAssessmentForCreate')->name('assessmentclone')->middleware('auth');
});


Route::controller(InviteConroller::class)->group(function(){
    Route::post('invite/list', 'index')->name('invite.list');
    // ... Write Generate link route ...
    Route::get('inviteusercall/{token}', 'handleToken')->name('invite.handleToken');
    Route::get('invitation/{token}', 'handleToken')->name('invite.inviteusercall');
    Route::get('invite/{assessmentID}/{userID?}', 'handleToken')->name('invite.inviteuserdirect');
    // Route::get('inviteusercall/{token}', 'inviteUrl')->name('invite.inviteusercall');
    
    Route::get('thankyou', 'thankyou')->name('invite.thankyou');
    // Route::post('thankyou', 'thankyou')->name('invite.thankyou');

    Route::get('attempt/{token}', 'startTest')->name('invite.test');
    Route::post('candidatesdetails', 'insertUserDetails')->name('candidatesdetails');
    Route::post('assessmentAttempts', 'assessmentAttempts')->name('assessmentAttempts.create');
    Route::post('emailval', 'checkEmail')->name('invite.checkEmail');
    Route::post('nameval', 'checkName')->name('invite.checkName');
    // Route::get('test/{token}', 'startTest')->name('invite.test');
});

Route::controller(ScoreController::class)->group(function(){
    Route::get('scoremanagement/list', 'index')->name('scoremanagement.list')->middleware('auth');

    Route::get('scoremanagement/assessment_result', 'assessment_result')->name('scoremanagement.assessment_result')->middleware('auth'); 
   
    Route::get('scoremanagement/ass', 'ass')->name('scoremanagement.ass')->middleware('auth');
    Route::post('scoremanagement/delete', 'delete')->name('scoremanagement.delete')->middleware('auth');
    Route::get('scoremanagement/feedback', 'feedback')->name('scoremanagement.feedback')->middleware('auth');
    Route::get('scoremanagement/view_feedback', 'view_feedback')->name('scoremanagement.view_feedback')->middleware('auth');
    Route::get('scoremanagement/index', 'index')->name('scoremanagement.index')->middleware('auth');
  });

Route::controller(DashbordController::class)->group(function(){
    Route::get('dashboard', 'index')->name('dashboard')->middleware('auth');
});

Route::controller(ProfileController::class)->group(function(){
    Route::get('profile', 'index')->name('profile')->middleware('auth');
    Route::post('profile/update','update')->name('profile.update');
});
