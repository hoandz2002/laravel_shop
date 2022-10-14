<?php

namespace App\Http\Controllers;

use App\Http\Requests\loginRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;


class AuthController extends Controller
{
    public function getLogin()
    {
        return view('auth.login');
    }
    // Hàm nhận thông tin login gửi lên
    public function postLogin(loginRequest $request)
    {
        // dd($request->all());
        // Lấy dữ liệu email, password người dùng gửi lên
        $email = $request->email;
        $password = $request->password;
        // $email = $request->input('email');
        // $data = $request->except('_token');
        // dd(
        //     Auth::attempt(['email' => $request->email, 'password' => $request->password])
        // );
        // Kiểm tra thông tin đăng nhập của người dùng
        if (Auth::attempt(['email' => $email, 'password' => $password])) {
            // trả về true thì điều hướng về trang home
            // if (Auth::user()->role === 1 && Auth::user()->status == 0) {
            //     return redirect()->route('users.list');
            // }
            // return redirect()->route('client.index');
            if (Auth::check()) {
                $user = Auth::user();
                if ($user->status == 0) {
                    if ($user->role == 1) {
                        return redirect()->route('admin.dashboard');
                    }if ($user->role == 0) {
                        return redirect()->route('client.index');
                        // dd('an cut');
                    }
                } else{
                    session()->flash('error','Tài khoản củ bạn đã bị khóa');
                    return redirect()->route('auth.getLogin');
                    // return back();
                    // return('tai khoan cua ban khong hoat dong');
                }
            }
        }
         else 
        {
            //nếu k khớp bản ghi nào trong db thì quay về login
            session()->flash('error','Tài khoản mật khẩu không chính xác !');
            return redirect()->route('auth.getLogin');
            // dd('cc');
        }
    }

    public function logout(Request $request)
    {
        // xoá session user đã đăng nhập
        Auth::logout();
        // 2 câu lệnh bên dưới có ở laravel 8 và 9
        // Huỷ toàn bộ session đi
        $request->session()->invalidate();
        // Tạo token mới
        $request->session()->regenerateToken();
        // Quay về màn login
        return redirect()->route('auth.getLogin');
    }
    public function getdangki()
    {
        return view('auth.dangki');
    }
    public function store(Request $request)
    {
      
        $user = new User();
    
        $user->fill($request->all());
        // 2. Kiểm tra file và lưu
        $user->password=Hash::make($request->password);
        if ($request->hasFile('avatar')) {
            $avatar = $request->avatar;
            $avatarName = $avatar->hashName();
            $avatarName = $request->username . '_' . $avatarName;
          
            $user->avatar = $avatar->storeAs('images/users', $avatarName);
          
        } else {
            $user->avatar = '';
        }
        // 3. Lưu $user vào CSDL
        $user->save();
        session()->flash('success','bạn đã đăng kí thành công');
        return redirect()->route('auth.getLogin');    }
}
