<?php

namespace App\Http\Controllers;
use App\Models\User;

use App\Models\AssignedUserRole;
use App\Models\UserRolePermission;
use App\Models\Modules;
use App\Models\UserRole;
use App\Http\Controllers\Controller;
use App\Mail\CreateUser;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Auth\Events\Validated;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use Symfony\Component\Console\Input\Input;


class UserManagement extends Controller
{

      public function search(Request $request)
      {

          $users = User::select('users.id as id','users.gender','users.phone','users.gender','users.email','users.lname','users.role_status','users.name','user_role.role_title','users.created_at')->where('name', 'like', "%{$request->search}%")
          ->leftjoin('user_role','users.role_id', '=', 'user_role.id')
          ->where('name', 'like', "%{$request->searchTerm}%")
          ->where('role_status', 'active')
          ->get();
          return response()->json($users);
      }


      public function index(Request $request)
      {
       $rolesData = UserRole::all();
       if($request->search !=""){
            $users = User::select('users.id as id','users.gender','users.phone','users.gender','users.email','users.lname','users.role_status','users.name','user_role.role_title','users.created_at')->where('name', 'like', "%{$request->search}%")
            ->leftjoin('user_role','users.role_id', '=', 'user_role.id')
            ->where('email', 'like', "%{$request->search}%")
            ->orderBy('id','DESC')
            ->paginate(5);
       }elseif($request->userrole !="" &&  $request->userstatus!='' && $request->startDate !=""){
            $start_date = date("Y-m-d",strtotime($request->startDate));
            $end_date = date('Y-m-d', strtotime($request->endDate));
            $users = User::select('users.id as id','users.gender','users.phone','users.gender','users.email','users.lname', 'users.role_status','users.name','user_role.role_title','users.created_at')->where('name', 'like', "%{$request->search}%")
            ->leftjoin('user_role','users.role_id', '=', 'user_role.id')
            ->where('email', 'like', "%{$request->search}%")
            ->where('role_id', '=', "{$request->userrole}")
            ->where('role_status', '=', "{$request->userstatus}")
            ->whereDate('users.created_at', '>=', $start_date)
            ->whereDate('users.created_at', '<=', $end_date)
            ->orderBy('id','DESC')
            ->paginate(5);
       }elseif($request->userrole !="" &&  $request->userstatus!=''){
            $users = User::select('users.id as id','users.gender','users.phone','users.gender','users.email','users.lname','users.role_status','users.name','user_role.role_title','users.created_at')->where('name', 'like', "%{$request->search}%")
            ->leftjoin('user_role','users.role_id', '=', 'user_role.id')
            ->where('email', 'like', "%{$request->search}%")
            ->where('role_id', '=', "{$request->userrole}")
            ->where('role_status', '=', "{$request->userstatus}")
            ->orderBy('id','DESC')
            ->paginate(5);
       }elseif($request->userstatus!='' && $request->startDate !=""){
            $start_date = date("Y-m-d",strtotime($request->startDate));
            $end_date = date('Y-m-d', strtotime($request->endDate));
            $users = User::select('users.id as id','users.gender','users.phone','users.gender','users.email','users.lname','users.role_status','users.name','user_role.role_title','users.created_at')->where('name', 'like', "%{$request->search}%")
            ->leftjoin('user_role','users.role_id', '=', 'user_role.id')
            ->where('email', 'like', "%{$request->search}%")
            ->whereDate('users.created_at', '>=', $start_date)
            ->whereDate('users.created_at', '<=', $end_date)
            ->where('role_status', '=', "{$request->userstatus}")
            ->orderBy('id','DESC')
            ->paginate(5);
        }elseif($request->userrole!='' && $request->startDate !=""){
            $start_date = date("Y-m-d",strtotime($request->startDate));
            $end_date = date('Y-m-d', strtotime($request->endDate));
            $users = User::select('users.id as id','users.gender','users.phone','users.gender','users.email','users.lname','users.role_status','users.name','user_role.role_title','users.created_at')->where('name', 'like', "%{$request->search}%")
            ->leftjoin('user_role','users.role_id', '=', 'user_role.id')
            ->where('email', 'like', "%{$request->search}%")
            ->whereDate('users.created_at', '>=', $start_date)
            ->whereDate('users.created_at', '<=', $end_date)
            ->where('role_id', '=', "{$request->userrole}")
            ->orderBy('id','DESC')
            ->paginate(5);
       }elseif($request->userrole!=''){
            $users = User::select('users.id as id','users.gender','users.phone','users.gender','users.email','users.lname','users.role_status','users.name','user_role.role_title','users.created_at')->where('name', 'like', "%{$request->search}%")
            ->leftjoin('user_role','users.role_id', '=', 'user_role.id')
            ->where('email', 'like', "%{$request->search}%")
            ->where('role_id', '=', "{$request->userrole}")
            ->orderBy('id','DESC')
            ->paginate(5);
       }elseif($request->userstatus!=''){
            $users = User::select('users.id as id','users.gender','users.phone','users.gender','users.email','users.lname','users.role_status','users.name','user_role.role_title','users.created_at')->where('name', 'like', "%{$request->search}%")
            ->leftjoin('user_role','users.role_id', '=', 'user_role.id')
            ->where('email', 'like', "%{$request->search}%")
            ->where('role_status', '=', "{$request->userstatus}")
            ->orderBy('id','DESC')
            ->paginate(5);
       }elseif($request->startDate!=''){

            $start_date = date("Y-m-d",strtotime($request->startDate));
            $end_date = date('Y-m-d', strtotime($request->endDate));
            $users = User::select('users.id as id','users.gender','users.phone','users.gender','users.email','users.lname','users.role_status','users.name','user_role.role_title','users.created_at')->where('name', 'like', "%{$request->search}%")
            ->leftjoin('user_role','users.role_id', '=', 'user_role.id')
            ->where('email', 'like', "%{$request->search}%")
            ->whereDate('users.created_at', '>=', $start_date)
            ->whereDate('users.created_at', '<=', $end_date)
            ->orderBy('id','DESC')
            ->paginate(5);

       }else{
            $users = User::select('users.id as id','users.gender','users.phone','users.gender','users.email','users.lname','users.role_status','users.name','user_role.role_title','users.created_at')->where('name', 'like', "%{$request->search}%")
            ->leftjoin('user_role','users.role_id', '=', 'user_role.id')
            ->where('email', 'like', "%{$request->search}%")
            ->orderBy('id','DESC')
            ->paginate(5);
       }

        return view('users.index', compact('users'),['rolesData' => $rolesData ]);
      }

      public function create()
      {
        $rolesData =  UserRole::select('user_role.id','user_role.role_title','status')
        ->where('user_role.status',1)
        ->get();
        return view('users.add',compact('rolesData'));
      }

      public function view($id)
      {

        $users = User::with('userRoleDetail')
        ->where('users.id', $id)
        ->get();
        $users = $users[0];
        return view('users/view', compact('users'));
      }


      public function edit($id)
      {
        //echo $id;exit;
        $users = User::find($id);
        $rolesData =  UserRole::select('user_role.id','user_role.role_title','status')
        ->where('user_role.status',1)
        ->get();

        return view('users/edit', compact('users','rolesData'));
      }


      public function update(Request $request, $id)
      {

        $request->validate([
          'name' => 'required|string|max:255',
          'lname' => 'required|string|max:255',
          'phone' => 'required|min:10|numeric',
          'email' => 'required|email',
          'userType' => 'required',
        ]);


       $user = User::find($id);

       $user->update([
        'name' => $request->name,
        'lname' => $request->lname,
        'phone' => $request->phone,
        'email' => $request->email,
        'role_status' =>'active',
        'role_id' => $request->role_id,
        'user_type' => $request->userType,

       ]);
     return redirect()->route('user.list')->with('success', 'User information is successfully updated.');

      }



      public function save(Request $request)
      {


        $validator = Validator::make($request->all(), [
          'name' => 'required|string|max:255',
          'lname' => 'required|string|max:255',
          'phone' => 'required|min:10|numeric',
          'email' => 'required|email|unique:users',
          'password' => 'min:8|required_with:confrim|same:confrim',
          'confrim' => 'min:8',
          'role' => 'required',
          'userType' => 'required',
        ]
        ,
        [
          'name.required'=> 'First name field  is required', // custom message
          'lname.required'=> 'Last name field is required', // custom message
          'phone.required'=> 'Phone number field is required', // custom message
          'email.required'=> 'Email field is required', // custom message
         ]
      );



        if ($validator->fails()) {

          return redirect()->back()
                            ->withErrors($validator)
                             ->withInput($request->all());
        }else{



          $user = new User();
          $user->name = $request->name;
          $user->lname = $request->lname;
          $user->email = $request->email;
          $user->password = bcrypt($request->password);
          $user->phone = $request->phone;
          $user->gender = '';
          $user->role_status = 'active';
          $user->role_id = $request->role;
          $user->user_type = $request->userType;
          $result = $user->save();
          $user->pass =$request->password;
          Mail::to($request->email)->send( new CreateUser($user));

          if($result){
            return redirect('user/list')->with('success', 'User Registraction is successful.');
          }

        }

      }


      public function status(Request $request)
      {

        $user = User::find($request->user_id);
        $user->role_status = $request->status;
        $user->save();
         return response()->json(['success'=>'Status '.$request->status.'.']);

      }

      public function createRole(){
        $roles = "";
        $users = '';
        $moduleList = Modules::all();
      //  echo "<pre>";
       // print_r($moduleList);
      //  exit;
        return view('users/create-role', compact('roles','users','moduleList'));
      }
      // save the role of the user
      public function postUserRole(Request $request){

        $requestData = $request->all();
        $role_title = $requestData['role_title'];
        $moduleids = $requestData['module_id'];
       // $vew_permission = $requestData['view_permission'];
       // $edit_permission = $requestData['edit_permission'];
       // $add_permission = $requestData['add_permission'];
       // $disable_permission = $requestData['disable_permission'];
        $vew_permission = array();
        $edit_permission = array();
        $add_permission = array();
        $disable_permission = array();
        if(isset($requestData['view_permission'])){
          $vew_permission = $requestData['view_permission'];
        }
        if(isset($requestData['edit_permission'])){
          $edit_permission = $requestData['edit_permission'];
        }
        if(isset($requestData['add_permission'])){
          $add_permission = $requestData['add_permission'];
        }
        if(isset($requestData['disable_permission'])){
          $disable_permission = $requestData['disable_permission'];
        }
        if(isset($requestData['checkAll']) && $requestData['checkAll'] == 'all'){
          $checked_all = 1;
        }else{
          $checked_all =0;
        }

        if($role_title !=''){

          $alreadyextData = UserRole::where('role_title','=',$role_title)->get();
          //$alreadyextData = $alreadyextData[0];

          if(!empty($alreadyextData[0]) && $alreadyextData[0]['id']!=''){
            // echo "jjj";exit;
             return redirect()->back()->with(array("error"=>"Role title is already exist."));
           }
          if(!empty($moduleids)){
            $role = new UserRole();
            $role->role_title = $role_title;
            $role->save();
            $insertedId = $role->id;
            if($insertedId!=''){
              foreach($moduleids as $mod_id){
                $rolePermission = new UserRolePermission();
                $rolePermission->module_id = $mod_id;
                $rolePermission->role_id = $insertedId;
                if(isset($vew_permission[$mod_id]) && $vew_permission[$mod_id]!=''){
                  $rolePermission->view_permission = 1;
                }

                if(isset($edit_permission[$mod_id]) && $edit_permission[$mod_id]!=''){
                  $rolePermission->edit_permission = 1;
                }
                if(isset($add_permission[$mod_id]) && $add_permission[$mod_id]!=''){
                  $rolePermission->add_permission = 1;
                }
                if(isset($disable_permission[$mod_id]) && $disable_permission[$mod_id]!=''){
                  $rolePermission->disable = 1;
                }
                $rolePermission->save();
                // fetch module if its already exist
                //$alreadyextData = Modules::where('module_id','=',$mod_id)->get();
                //if(!empty($alreadyextData)){
                 // Modules::where('module_id','=',$mod_id)->delete();
                //}
              }
            }
          }
        }else{
            return redirect()->back()->with(array("error"=>"No title, Please enter role title"));

        }
        return redirect()->back()->with(array("success"=>"Role has been created"));
        //->withInput(Input::all());
      }
      // list roles
      public function listRoles(){
        // fetch all modules
        $all_module_id = array();
        $moduleList = Modules::select('id')->where('status','=','active')->get();
        foreach($moduleList as $mod_ids){
          $all_module_id[] = $mod_ids->id;
        }

        $full_access = 0;
        $rolesData = UserRole::all();
        $role_data_arr = array();
        $rolesData =  UserRole::select('user_role.role_title','user_role.id','module_id','status','edit_permission','view_permission','add_permission','disable','checked_all')
        ->join('user_roles_permission', 'user_role.id', '=', 'user_roles_permission.role_id')
        ->orderBy('id','DESC')
        ->get();
        foreach($rolesData as $roleData){
          $role_data_arr[$roleData->id]['role_title'] = $roleData->role_title;
          $role_data_arr[$roleData->id]['edit_permission'] = $roleData->edit_permission;
          $role_data_arr[$roleData->id]['view_permission'] = $roleData->view_permission;
          $role_data_arr[$roleData->id]['add_permission'] = $roleData->add_permission;
          $role_data_arr[$roleData->id]['disable'] = $roleData->add_permission;
          $role_data_arr[$roleData->id]['module_id'][] = $roleData->module_id;
          $role_data_arr[$roleData->id]['status'] = $roleData->status;
          $role_data_arr[$roleData->id]['checked_all'] = $roleData->checked_all;
        /* if(in_array($roleData->module_id,$all_module_id)){
            $role_data_arr[$roleData->id]['full_access'] = 1;
          }else{
            $role_data_arr[$roleData->id]['full_access'] = 0;
          }*/

        }
    /*   echo "<pre>";
        print_r($role_data_arr);
        exit;*/
        return view('users/list-role', compact('role_data_arr','all_module_id'));
      }
      // edit role
      public function editRole(Request $request){
        //echo $request->id;exit;
        $viewModulePer = array();
        $editModulePer = array();
        $addModulePer = array();
        $disableModulePer = array();
        $rolesData =  UserRole::select('user_role.id','user_roles_permission.module_id','user_role.role_title','status','edit_permission','view_permission','add_permission','disable','checked_all')
        ->join('user_roles_permission', 'user_role.id', '=', 'user_roles_permission.role_id')->where('user_role.id',$request->id)
        ->get();
        $role_id = $request->id;
      /* echo "<pre>";
        print_r($rolesData);
        exit;*/
        $role_title = '';
        // echo "<pre>";
        // print_r($rolesData);

        foreach($rolesData as $rolData){
          if($rolData->view_permission == 1){
            $viewModulePer[] =  $rolData->module_id;
            $roleData['view_permission'] = 1;
          }else{
            $roleData['view_permission'] = 0;
          }
          if($rolData->edit_permission == 1){
            $editModulePer[] =  $rolData->module_id;
            $roleData['edit_permission'] = 1;
          }else{
            $roleData['edit_permission'] = 0;
          }
          if($rolData->add_permission == 1){
            $addModulePer[] =  $rolData->module_id;
            $roleData['add_permission'] = 1;
          }else{
            $roleData['add_permission'] = 0;
          }
          if($rolData->disable == 1){
            $disableModulePer[] =  $rolData->module_id;
            $roleData['disable'] = 1;
          }else{
            $roleData['disable'] = 0;
          }
          $role_title = $rolData->role_title;
          $role_data_arr['module_id'][] = $rolData->module_id;
        }
        $moduleList = Modules::all();

        $all_module_id = array();
        $moduleList11 = Modules::select('id')->where('status','=','active')->get();
        foreach($moduleList11 as $mod_ids){
          $all_module_id[] = $mod_ids->id;
        }
        $full_access = 0;
        // echo "<pre>";
        // print_r($role_data_arr['module_id']);
        // echo "<pre>";
        // print_r($all_module_id);
        // exit;
        if($role_data_arr['module_id'] == $all_module_id && $roleData['edit_permission'] == 1 && $roleData['view_permission'] == 1 && $roleData['add_permission'] == 1){
          $full_access = 1;
        }

        return view('users/edit-role', compact('rolesData','role_id','moduleList','viewModulePer','editModulePer','addModulePer','disableModulePer','role_title','full_access'));
      }
      // edit role
      public function editUserRole(Request $request){
      // dd($request);
        $requestData = $request->all();
        if(isset($requestData['edit_permission']))
        $edit_permission = $requestData['edit_permission'];

          $role_title = $requestData['role_title'];
          $moduleids = $requestData['module_id'];
          $vew_permission = array();
          $edit_permission = array();
          $add_permission = array();
          $disable_permission = array();
          if(isset($requestData['view_permission'])){
            $vew_permission = $requestData['view_permission'];
          }
          if(isset($requestData['edit_permission'])){
            $edit_permission = $requestData['edit_permission'];
          }
          if(isset($requestData['add_permission'])){
            $add_permission = $requestData['add_permission'];
          }
          if(isset($requestData['disable_permission'])){
            $disable_permission = $requestData['disable_permission'];
          }
          if(isset($requestData['checkAll']) && $requestData['checkAll'] == 'all'){
            $checked_all = 1;
          }else{
            $checked_all =0;
          }



          if($role_title !=''){
            $alreadyextData = UserRole::where('role_title','=',$role_title)->where('id','!=',$requestData['role_id'])->get();

            if(empty($alreadyextData)){
              return redirect()->back()->withErrors(array("0"=>"Role title already exist."));
            }
            if(!empty($moduleids)){
              $role = new UserRole();

              UserRole::where('id', $requestData['role_id'])->update(array('role_title' => $role_title,'checked_all'=>$checked_all));

              $insertedId = $requestData['role_id'];
              if($insertedId!=''){
                UserRolePermission::where('role_id','=',$requestData['role_id'])->delete();
                foreach($moduleids as $mod_id){
                  $rolePermission = new UserRolePermission();
                  $rolePermission->module_id = $mod_id;
                  $rolePermission->role_id = $insertedId;
                  if(isset($vew_permission[$mod_id]) && $vew_permission[$mod_id]!=''){
                    $rolePermission->view_permission = 1;
                  }

                  if(isset($edit_permission[$mod_id]) && $edit_permission[$mod_id]!=''){
                    $rolePermission->edit_permission = 1;
                  }
                  if(isset($add_permission[$mod_id]) && $add_permission[$mod_id]!=''){
                    $rolePermission->add_permission = 1;
                  }
                  if(isset($disable_permission[$mod_id]) && $disable_permission[$mod_id]!=''){
                    $rolePermission->disable = 1;
                  }
                  $rolePermission->save();
                  // fetch module if its already exist
                  //$alreadyextData = Modules::where('module_id','=',$mod_id)->get();
                  //if(!empty($alreadyextData)){
                  // Modules::where('module_id','=',$mod_id)->delete();
                  //}
                }
              }
            }
          }else{
              return redirect()->back()->withErrors(array("0"=>"No title, Please enter role title"));

          }
          return redirect()->back()->with(array("success"=>"Role and access permission updated successfully"));
          //->withInput(Input::all());

      }
      public function roleStatus(Request $request)
      {
        $user = UserRole::find($request->role_id);
        $user->status = $request->status;
        $user->save();
        if($request->status == 1){
          $status = 'Active';
        }else{
          $status = 'Inactive';
        }

        return response()->json(['success'=>'Status '.$status.'.']);

      }
      // view role
      public function viewRole(Request $request){
          //echo $request->id;exit;
        $viewModulePer = array();
        $editModulePer = array();
        $addModulePer = array();
        $disableModulePer = array();
        $rolesData =  UserRole::select('user_role.id','user_roles_permission.module_id','user_role.role_title','status','edit_permission','view_permission','add_permission','disable','checked_all')
        ->join('user_roles_permission', 'user_role.id', '=', 'user_roles_permission.role_id')->where('user_role.id',$request->id)
        ->get();
        $role_id = $request->id;
      // echo "<pre>";
      // print_r($rolesData);
        //exit;
        $role_title = '';
        foreach($rolesData as $rolData){
          if($rolData->view_permission == 1){
            $viewModulePer[] =  $rolData->module_id;
          }
          if($rolData->edit_permission == 1){
            $editModulePer[] =  $rolData->module_id;
          }
          if($rolData->add_permission == 1){
            $addModulePer[] =  $rolData->module_id;
          }
          if($rolData->disable == 1){
            $disableModulePer[] =  $rolData->module_id;
          }
          $role_title = $rolData->role_title;
        }
        $moduleList = Modules::all();
        /* $rolesData =  UserRole::select('user_role.role_title','status','edit_permission','view_permission','add_permission','disable')
      ->join('user_roles_permission', 'user_role.id', '=', 'user_roles_permission.role_id')
      ->get();
        echo "<pre>";
        print_r( $rolesData);
        exit;*/
        return view('users/view-role', compact('rolesData','role_id','moduleList','viewModulePer','editModulePer','addModulePer','disableModulePer','role_title'));
      }
      // ajax list role
      public function ajaxListRoles(Request $request){
        // fetch all modules

        $all_module_id = array();
        $moduleList = Modules::select('id')->where('status','=','active')->get();
        foreach($moduleList as $mod_ids){
          $all_module_id[] = $mod_ids->id;
        }
        $searchKey = $request->input('searchKey');
        $full_access = 0;
        // $rolesData = UserRole::all();
        $role_data_arr = array();
        if($searchKey!=''){
          $rolesData =  UserRole::select('user_role.role_title','user_role.id','module_id','status','edit_permission','view_permission','add_permission','disable','checked_all','user_role.role_type')
          ->join('user_roles_permission', 'user_role.id', '=', 'user_roles_permission.role_id')
          ->where('user_role.role_title', 'like', "%{$request->searchKey}%")
          ->orderby('id','DESC')
          ->paginate(5);
        }else{

          $rolesData =  UserRole::select('user_role.role_title','user_role.id','module_id','status','edit_permission','view_permission','add_permission','disable','user_role.checked_all','user_role.role_type')
          ->join('user_roles_permission', 'user_role.id', '=', 'user_roles_permission.role_id')
          ->orderBy('user_role.id','DESC')
          ->get();
        }
        //     echo "<pre>";
        // print_r($rolesData);
        //  $rolesData = $rolesData.toArray();
          //  echo "<pre>";
          //  print_r($rolesData);
          // exit;

        foreach($rolesData as $roleData){
          $role_data_arr[$roleData->id]['role_title'] = $roleData->role_title;
          $role_data_arr[$roleData->id]['edit_permission'] = $roleData->edit_permission;
          $role_data_arr[$roleData->id]['view_permission'] = $roleData->view_permission;
          $role_data_arr[$roleData->id]['add_permission'] = $roleData->add_permission;
          $role_data_arr[$roleData->id]['disable'] = $roleData->add_permission;
          $role_data_arr[$roleData->id]['module_id'][] = $roleData->module_id;
          $role_data_arr[$roleData->id]['status'] = $roleData->status;
          $role_data_arr[$roleData->id]['checked_all'] = $roleData->checked_all;
          $role_data_arr[$roleData->id]['role_type'] = $roleData->role_type;
          /* if(in_array($roleData->module_id,$all_module_id)){
            $role_data_arr[$roleData->id]['full_access'] = 1;
          }else{
            $role_data_arr[$roleData->id]['full_access'] = 0;
          }*/

        }

        //  exit;
        // $role_data_arr = $rolesData;
        return view('users/ajax-list-role', compact('role_data_arr','all_module_id'));

      //  if ($request->ajax()) {
        // return view('users/ajax-list-role', ['role_data_arr' => $role_data_arr])->render();
        //}
      }
}
