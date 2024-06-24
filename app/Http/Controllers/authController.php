<?php

namespace App\Http\Controllers;

use App\Events\ForgotPassword;
use App\Events\RegisterSuccess;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use App\Mail\RegisterMail;
// use App\Mail\ForgotPassword;
use Carbon\Carbon;
use Illuminate\Support\Str;

class authController extends Controller
{
    public function login_admin()
    {
        if (!empty(Auth::check()) && Auth::user()->is_admin == 1) {
            return redirect('admin/dashboard');
        }
        return view('admin.auth.login');
    }
    public function auth_login_admin(Request $request)
    {
        $remember = !empty($request->remember) ? true : false;
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password, 'is_admin' => 1, 'status' => 0, 'is_deleted' => 0], $remember)) {
            return redirect('admin/dashboard');
        } else {
            return redirect()->back()->with('error', "Vui lòng nhập đúng mật khẩu");
        };
    }

    public function logout()
    {
        Auth::logout();
        return redirect(url(''));
    }

    public function auth_register_client(Request $request)
    {
        $checkEmail = User::checkEmail($request->email);
        // dd($checkEmail);
        if (empty($checkEmail)) {
            $user = new User;
            $user->name = $request->username;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->save();
            RegisterSuccess::dispatch($user);
          
            $json['status'] = true;
            $json['message'] = 'Đăng kí thành công, vui lòng xác thực Email';
        } else {
            $json['status'] = false;
            $json['message'] = 'Email đã tồn tại';
        }
        echo json_encode($json);
    }
    public function activateMail($id)
    {
        $id = base64_decode($id);
        $user = User::find($id);
        $user->email_verified_at =  Carbon::now();
        $user->save();
        return redirect(url(''))->with('success', 'Xác thực thành công');
    }
    public function auth_login_client(Request $request)
    {
        $remember = !empty($request->remember) ? true : false;
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password, 'status' => 0, 'is_deleted' => 0], $remember)) {
            if (!empty(Auth::user()->email_verified_at)) {
                $json['status'] = true;
                $json['message'] = 'Đăng nhập thành công';
            } else {
                $user = User::find(Auth::user()->id);
                Mail::to($user->email)->send(new RegisterMail($user));
                $json['status'] = false;
                $json['message'] = 'Tài khoản của bạn chưa được xác minh, vui lòng kiểm tra email và xác minh';
            }
        } else {

            $json['message'] = 'Tài khoản hoặc mật khẩu sai';
        };
        echo json_encode($json);
    }
    public function forgot_password()
    {
        $meta_title = 'Quên mật khẩu';
        return view('client.auth.forgot-pass', [
            'meta_title' => $meta_title
        ]);
    }
    public function auth_forgot_password(Request $request)
    {
        $user = User::checkEmail($request->email);
        if (!empty($user)) {
            $user->remember_token = Str::random(30);
            $user->save();
            
            ForgotPassword::dispatch($user);
            return redirect()->back()->with('success', "Vui lòng kiểm tra email và đặt lại mật khẩu");
        } else {
            return redirect()->back()->with('error', "Email không tồn tại trên hệ thống");
        }
    }
    public function reset($token){
        $meta_title = 'Đặt lại mật khẩu';
        return view('client.auth.reset',[
            'meta_title'=>$meta_title
        ]);
    }
    public function reset_password($token,Request $request){

        if($request->password == $request->re_password){
            $user = User::where('remember_token','=',$token)->first();
            
            $user->password = Hash::make($request->password);
            $user->remember_token = Str::random(30);
            $user->save();
            return redirect(url(''))->with('success',"Đặt lại mật khẩu thành công");
        }else{
            return redirect()->back()->with('error',"Xác nhận mật khẩu không khớp");
        }
 
    }
}
