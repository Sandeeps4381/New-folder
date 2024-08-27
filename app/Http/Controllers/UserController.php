<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Mail\SendPassword;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Models\UserRole;

class UserController extends Controller
{
    function index()
    {
        return view('auth/login');
    }


    public function forgetPassword()
    {
        return view('auth/forgetpassword');
    }

    public function resetPassword($token)
    {
        return view('auth/reset' , ['token' => $token]);
    }
    
    function validate_registration(Request $request)
    {
        $request->validate([
            'email'        =>   'required|email|unique:users',
            'password'     =>   'required|min:6'
        ]);

        $data = $request->all();

        User::create([
            'email' =>  $data['email'],
            'password' => Hash::make($data['password'])
        ]);

        return redirect('login')->with('success', 'Registration Completed, now you can login');
    }

    function validate_login(Request $request)
    {
        $request->validate([
            'email' =>  'required',
            'password'  =>  'required'
        ]);

        $credentials = $request->only('email', 'password');
    
        if(Auth::attempt($credentials))
        {
            $user = User::where('email','=', $request->email)->get();  
            if($user[0]->role_status == 'active'){
                Session::put('user_id',$user[0]->id);
                 // get module of the logingedin user
                if($user[0]->role_id!=''){
                    Session::put('role_id',$user[0]->role_id);
                    $role_id = $user[0]->role_id;
                    $role_data_arr = array();
                    $rolesData =  UserRole::select('user_role.role_title','user_role.id','module_id','status','edit_permission','view_permission','add_permission','disable','checked_all')
                   ->join('user_roles_permission', 'user_role.id', '=', 'user_roles_permission.role_id')
                   ->where('user_role.id','=',$role_id)
                   ->where('user_role.status','=',1)
                   ->get();
                     foreach($rolesData as $roleData){
                      // $role_data_arr[$roleData->module_id]['role_title'] = $roleData->role_title;
                       if($roleData->edit_permission == 1){
                            $role_data_arr[$roleData->module_id]['edit_permission'] = $roleData->edit_permission;
                       }
                       if($roleData->view_permission == 1){
                        $role_data_arr[$roleData->module_id]['view_permission'] = $roleData->view_permission;
                       }
                       if($roleData->add_permission == 1){
                        $role_data_arr[$roleData->module_id]['add_permission'] = $roleData->add_permission;
                       }
                       if($roleData->disable == 1){
                        $role_data_arr[$roleData->module_id]['disable'] = $roleData->disable;
                       }
                      // if($roleData->status == 1){
                     //   $role_data_arr[$roleData->module_id]['status'] = $roleData->status;
                      // }                  
                       
                       
                       //$role_data_arr[$roleData->module_id]['checked_all'] = $roleData->checked_all;                      
               
                     }
                     Session::put('role_module_permission',$role_data_arr);

                }

                if(isset($request->remember_me) && !empty(($request->remember_me))){
                    setcookie('email', $credentials['email'], time() + 3600);
                    setcookie('password', $credentials['password'], time() + 3600);
                }else{
                    setcookie('email', "");
                    setcookie('password', "");
                }
            
                return redirect('dashboard')->with('success', 'Login successful.');
            }else{
                return redirect()->back()->with('error', 'The account is inactive.');
            }
        }

        return redirect()->back()->with('error', 'Login credentials are invalid.');
    }


    public function forgetpasswordsend(Request $request){
       //echo $request->email;
        $user = User::where('email', $request->email)->first();
       // $user = array("name"=>"Mohan","email"=>"mohan.p@vtechsolution.com","remember_token"=>"hksfdh");
        //Mail::to($request->email)->send( new SendPassword($user));
       // exit;
        if(!empty($user)){
             $date = date('Y/m/d h:i:s');
             $user->remember_token = Str::random(30);
             $user->forget_token_gen_time = $date;
             $user->save();
             Mail::to($request->email)->send( new SendPassword($user));
 
             return redirect()->back()->with('success','Password reset instructions are sent to the registered email id.');
        }else{
             return redirect()->back()->with('error','The entered email id is unregistered.');
        }
        
     }
 
 
     public function passwordReset(Request $request){
         $request->validate([
             'password' => 'required|string|min:8|confirmed',
             'password_confirmation' => 'required',
         ]);
        
        
         $updatePassword = User::where('remember_token', $request->token) -> first();
         $tokenDate =  date('Y-m-d', strtotime($updatePassword->forget_token_gen_time));
         $start_date = date("Y-m-d");
         $end_date = date('Y-m-d', strtotime('+1 day', strtotime($start_date)));

        if($tokenDate  >=  $start_date && $tokenDate  <=  $end_date){
            if(!$updatePassword){
                return redirect()->back()->withInput()->with('error', 'Invalid token!');
            }else{
                $user = User::where('remember_token',  $request->token)
                        ->update(['password' => bcrypt($request->password)]);
                        return redirect('/')->with('success', 'Your password is successfully reset.');
            }
        }else{
            return redirect()->back()->withInput()->with('error', 'Token is expire.');
        }
         
     }
 

    function logout()
    {
        Session::flush();
        Auth::logout();
        return Redirect('/');
    }
}
