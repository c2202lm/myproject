<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Session;

use Illuminate\Http\Request;

class loginController extends Controller
{
    // public function login(){
    //     return view('login');
    // }
    protected function login(Request $request){
        
        $rules = [
            'name' => 'required|name',
            'password' => 'required|min:6'
        ];
        $messages = [
            'name.required' => 'Điền tên đăng nhập',
            'password.required' => 'Điền mật khẩu đăng nhập'
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        if($validator -> fails()){
            //điều kiện dữ liệu không hợp lệ chuyển về trang login và thông báo lỗi
            return redirect('login')->withErrors($validator)->withInput();
        }else{
            //nếu dữ liệu hợp lệ sẽ kiểm tra trong cơ sở dữ liệu
            $name = $request->input('name');
            $password = $request->input('password');
            if(Auth::attempt(['name' => $name, 'password' => $password])){
                //kiểm tra mật khẩu đúng sẽ chuyển trang
                return redirect('index');
            }else{
                //kiểm tra ko đúng báo lỗi và trả về trong login
                Session::flash('error', 'tài khoản hoặc mật khẩu không chính xác');
                return redirect('login');
            }
        }

        
    }
}
