<?php

namespace App\Http\Controllers;

use App\Models\OrdersModel;
use App\Models\ProductModel;
use App\Models\WishlistProduct;
use App\Models\EvaluateModel;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function dashboard()
    {
        $meta_title = 'Bảng điều khiển';
        $meta_description = '';
        $meta_keywords = '';

        $getTotalOrderUser = OrdersModel::getTotalOrderUser(Auth::user()->id);
        $getTotalTodayOrderUser = OrdersModel::getTotalTodayOrderUser(Auth::user()->id);
        $getTotalAmountOrderUser =  OrdersModel::getTotalAmountOrderUser(Auth::user()->id);
        $getTotalTodayAmountOrderUser =  OrdersModel::getTotalTodayAmountOrderUser(Auth::user()->id);

        $pending =  OrdersModel::getTotalStatusOrder(Auth::user()->id, 0);
        $processing =  OrdersModel::getTotalStatusOrder(Auth::user()->id, 1);
        $delivering =  OrdersModel::getTotalStatusOrder(Auth::user()->id, 2);
        $completed =  OrdersModel::getTotalStatusOrder(Auth::user()->id, 3);
        $cancelled =  OrdersModel::getTotalStatusOrder(Auth::user()->id, 4);


        return view('client.user.UserDashboard', [
            'meta_title' => $meta_title,
            'meta_description' => $meta_description,
            'meta_keywords' => $meta_keywords,
            'getTotalOrderUser' => $getTotalOrderUser,
            'getTotalTodayOrderUser' => $getTotalTodayOrderUser,
            'getTotalAmountOrderUser' => $getTotalAmountOrderUser,
            'getTotalTodayAmountOrderUser' => $getTotalTodayAmountOrderUser,
            'pending' => $pending,
            'processing' => $processing,
            'delivering' => $delivering,
            'completed' => $completed,
            'cancelled' => $cancelled,
        ]);
    }
    public function orders()
    {
        $meta_title = 'Đơn hàng của tôi';
        $meta_description = '';
        $meta_keywords = '';
        $getOrderByUser = OrdersModel::getOrderByUser(Auth::user()->id);

        return view('client.user.orders', [
            'meta_title' => $meta_title,
            'meta_description' => $meta_description,
            'meta_keywords' => $meta_keywords,
            'getOrderByUser' => $getOrderByUser
        ]);
    }
    public function editProfile()
    {
        $meta_title = 'Chỉnh sửa thông tin';
        $meta_description = '';
        $meta_keywords = '';
        $user = User::find(Auth::user()->id);
        return view('client.user.edit-profile', [
            'meta_title' => $meta_title,
            'meta_description' => $meta_description,
            'meta_keywords' => $meta_keywords,
            'user' => $user
        ]);
    }

    public function updateProfile(Request $request)
    {

        $user = User::find(Auth::user()->id);
        $user->name = $request->lastName;
        $user->firstName = $request->firstName;
        $user->address = $request->address;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->save();
        return redirect()->back()->with('success', 'Cập nhật thành công');
    }
    public function changePassword()
    {
        $meta_title = 'Thay đổi mật khẩu';
        $meta_description = '';
        $meta_keywords = '';
        return view('client.user.change-password', [
            'meta_title' => $meta_title,
            'meta_description' => $meta_description,
            'meta_keywords' => $meta_keywords,
        ]);
    }

    public function updateNewPassword(Request $request)
    {
        $user = User::find(Auth::user()->id);
        if (Hash::check($request->old_password, $user->password)) {
            if ($request->password == $request->confirmPassword) {
                $user->password = Hash::make($request->password);
                $user->save();
                return  redirect()->back()->with('success', 'Đổi mật khẩu thành công');
            } else {
                return  redirect()->back()->with('error', 'Mật khẩu mới không khớp');
            }
        } else {
            return redirect()->back()->with('error', 'Mật khẩu cũ không đúng');
        }
    }

    public function orderDetail($id)
    {
        $meta_title = 'Chi tiết đơn hàng';
        $meta_description = '';
        $meta_keywords = '';
        $getOrderDetailByUserOrder = OrdersModel::getOrderDetailByUserOrder(Auth::user()->id, $id);
        if (!empty($getOrderDetailByUserOrder)) {
            return view('client.user.order-detail', [
                'meta_title' => $meta_title,
                'meta_description' => $meta_description,
                'meta_keywords' => $meta_keywords,
                'getOrderDetailByUserOrder' => $getOrderDetailByUserOrder
            ]);
        } else {
            abort(404);
        }
    }

    public function addWishlist(Request $request)
    {
        if (empty(WishlistProduct::checkWishlistproductAlready(Auth::user()->id, $request->product_id))) {
            $WishlistProduct = new WishlistProduct;
            $WishlistProduct->user_id = Auth::user()->id;
            $WishlistProduct->product_id = $request->product_id;
            $WishlistProduct->save();
            $json['status'] = true;
        } else {
            WishlistProduct::DeleteRecord(Auth::user()->id, $request->product_id);
            $json['status'] = false;
        }
        echo json_encode($json);
    }

    public function listMyWishlist()
    {
        $getProduct = ProductModel::getProductWishList(Auth::user()->id);
        // dd($getProduct);
        return view('client.product.wishlist', [
            'getProduct' => $getProduct
        ]);
    }
    public function evaluate(Request $request){
        
        $EvaluateModel = new EvaluateModel;
        $EvaluateModel->user_id = Auth::user()->id;
        $EvaluateModel->order_id = $request->order_id;
        $EvaluateModel->product_id = $request->product_id;
        $EvaluateModel->star = $request->starValue;
        $EvaluateModel->review = $request->reviewText;
        $EvaluateModel->save();

        $json['status'] = true;
        $json['message'] = "Đánh giá thành công";
        echo json_encode($json);
        // return redirect()->back();
    }
}
