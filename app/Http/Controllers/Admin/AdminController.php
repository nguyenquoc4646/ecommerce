<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;


class AdminController extends Controller
{
    public function list()
    {
        $data = User::query()->where('is_deleted', 0)->latest('id')->paginate(10);

        return view('admin.admin.list', compact('data'));
    }
    public function add()
    {
        return view('admin.admin.add');
    }
    public function insert(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:users',
            'username' => 'required|min:4|unique:users,name',
            'password' => 'nullable|min:8',
        ],[
            'email.required' => 'Email là bắt buộc.',
            'email.email' => 'Email phải là định dạng hợp lệ.',
            'email.unique' => 'Email đã tồn tại.',
            'username.unique' => 'Tên người dùng đã tồn tại.',
            'username.required' => 'Username là bắt buộc.',
            'username.min' => 'Tên người dùng phải có ít nhất 4 ký tự.',
            'password.min' => 'Mật khẩu phải có ít nhất 8 ký tự.',
        ]);

        $user = new User;
        $user->name = $request->username;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->status = $request->status;
        $user->is_admin = $request->role == true ? 1 : 0;
        $user->save();
        return redirect('admin/admin/list')->with('success', 'Thêm tài khoản thành công');
    }
    public function edit($id)
    {

        $data = User::find($id);
        return view('admin.admin.edit', [
            'data' => $data
        ]);
    }
    public function update($id, Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:users,email,' . $id,
            'username' => 'required|min:4|unique:users,name,' . $id,
            'password' => 'nullable|min:8',
        ], [
            'email.required' => 'Email là bắt buộc.',
            'email.email' => 'Email phải là định dạng hợp lệ.',
            'email.unique' => 'Email đã tồn tại.',
            'username.required' => 'Username là bắt buộc.',
            'username.unique' => 'Tên người dùng đã tồn tại.',
            'username.min' => 'Username phải có ít nhất 4 kí tự.',
            'password.min' => 'Mật khẩu phải có ít nhất 8 ký tự.',
        ]);
        $user = User::find($id);
        $user->name = $request->username;
        $user->email = $request->email;
        if (!empty($request->password)) {
            $user->password = Hash::make($request->password);
        }
        $user->status = $request->status;
        $user->is_admin = $request->role == true ? 1 : 0;
        $user->save();
        return redirect('admin/admin/list')->with('success', 'Cập nhật tài khoản thành công');
    }

    public function delete($id)
    {
        $user = User::find($id);
        if ($user) {
            $user->is_deleted = 1;
            $user->save();
        }
        return redirect('admin/admin/list')->with('success', 'Xóa tài khoản thành công');
    }
}
