<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Http\Requests\UserUpdateRequest;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {

        $usersPaginate = User::select('id', 'name', 'avatar', 'username', 'email', 'status', 'role')
            // ->cursorPaginate(5);
            ->paginate(5);
        // dd($usersPaginate);
        return view('admin.users.list', ['user_list' => $usersPaginate]);
    }
    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {

        $user = new User();

        $user->fill($request->all());
        // 2. Kiểm tra file và lưu
        $user->password = Hash::make($request->password);
        if ($request->hasFile('avatar') ) {
            $avatar = $request->avatar;
            $avatarName = $avatar->hashName();
            $avatarName = $request->username . '_' . $avatarName;

            $user->avatar = $avatar->storeAs('images/users', $avatarName);
        } else {
            $user->avatar = '';
        }
        // 3. Lưu $user vào CSDL
        $user->save();
        if (Auth::check()) {
            return redirect()->route('users.list');
        } else {
            session()->flash('success', 'bạn đã đăng kí thành công');
            return redirect()->route('auth.getLogin');
        }
    }
    public function edit(User $user)
    {
        return view('admin.users.create', [
            'user' => $user,
        ]);
    }
    public function update(User $user, UserRequest $request)
    {
        $userEdit = User::find($user->id);
        // dd($request->all());
        $userEdit->name = $request->name;
        $userEdit->username = $request->username;
        $userEdit->password = $request->password;
        $userEdit->email = $request->email;

        $request->avatar ? $userEdit->avatar = $request->avatar : $userEdit->avatar = $userEdit->avatar;

        //
        if ($request->hasFile('avatar')) {
            $avatarName = $request->avatar->hashName();
            $avatarName = $request->username . '_' . $avatarName;
            $userEdit->avatar = $request->avatar->storeAs('images/users', $avatarName);
        } else {
            $userEdit->avatar = $userEdit->avatar;
        }
        //
        // if($request->role) {
        //     $userEdit->role = $request->role;
        // } else {
        //     $userEdit->role = $userEdit->role;
        // } 
        $request->role ? $userEdit->role = $request->role : $userEdit->role = $userEdit->role;
        //
        $request->status ? $userEdit->status = $request->status : $userEdit->status = $userEdit->status;

        // if($request->password){
        //     $user->password=hash($request->password);
        // }
        $userEdit->save();
        return redirect()->route('users.list');
    }
    public function delete($user)
    {
        $data = User::find($user);
        $data->delete();
        return redirect()->route('users.list');
    }
    public function updateStatus($user)
    {
        $updateStatus = User::find($user);
        if ($updateStatus->status == 0) {
            $updateStatus->status = 1;
        } else {
            $updateStatus->status = 0;
        }
        $updateStatus->save();
        session()->flash('success', 'Bạn đã cập nhật trạng thái thành công!');
        return redirect()->route('users.list');
        // return redirect()->back();
    }
    //
    public function getdangki()
    {
        return view('auth.dangki');
    }
    public function postForm(Request $request)
    {
        // dd($request->all());

        $user = new User();

        $user->fill($request->all());
        if ($request->hasFile('avatar')) {
            $avatar = $request->avatar;
            $avatarName = $avatar->hashName();
            $avatarName = $request->username . '_' . $avatarName;

            $user->avatar = $avatar->storeAs('images/users', $avatarName);
        } else {
            $user->avatar = '';
        }
        $user->password = Hash::make($request->password);
        $user->save();
        return redirect()->route('auth.getLogin');
    }
}
