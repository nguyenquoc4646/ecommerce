<?php

namespace App\Http\Controllers\Client;

use App\Events\OrderSuccess;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\DiscountModel;
use Illuminate\Http\Request;
use App\Models\ProductModel;
use App\Models\ProductSizeModel;
use App\Models\ShippingModel;
use App\Models\ColorModel;
use App\Models\OrdersModel;
use App\Models\User;
use App\Models\OrderItemModel;
use App\Models\Statistical;
use Darryldecode\Cart\Facades\CartFacade as Cart;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class PaymentControllerClient extends Controller
{
    public function deleteCart(Request $request)
    {
        if (!empty($request->id_cart)) {
            Cart::remove($request->id_cart);
            $message = 'Xóa thành công';
            return response()->json(['status' => true, 'message' => $message]);
        }
    }
    public function cart(Request $request)
    {
        $meta_title = 'Giỏ hàng';
        // $itemId = '178118dd9f1041a5';
        // Cart::clear();
        // dd(Cart::getContent());

        return view('client.payment.cart', [
            'meta_title' => $meta_title
        ]);
    }

    public function addToCart(Request $request)
    {
        $getProduct = ProductModel::find($request->product_id);
        $totalPrice = $getProduct->price;


        if (!empty($request->size_id)) {
            $size_id = $request->size_id;
            $getSize = ProductSizeModel::find($request->size_id);

            $price = ($getSize->price) ? $getSize->price : 0;
            $totalPrice = $totalPrice + $price;
        } else {
            $size_id = 0;
        }
        $color_id = !empty($request->color_id) ? $request->color_id : 0;

        // $randomString = bin2hex(random_bytes(5));
        $uniqueId = md5($getProduct->id . $size_id . $color_id);
        // Add the item to the cart with the unique identifier
        Cart::add([
            'id' => $uniqueId,  // Use the unique identifier here
            'name' => 'Product',
            'price' => $totalPrice,
            'quantity' => $request->quantity,
            'attributes' => [
                'product_id' => $getProduct->id,
                'size_id' => $size_id,
                'color_id' => $color_id,
            ]
        ]);
        $message = 'Thêm giỏ hàng thành công';
        return response()->json(['status' => true, 'message' => $message]);
    }

    public function updateCart(Request $request)
    {
        $cartItem = Cart::get($request->idCart);
        $getProduct = ProductModel::find($cartItem->attributes['product_id']);
        $getProductSize = ProductSizeModel::find($cartItem->attributes['size_id']);
        $basePrice = $getProduct->price;
        $sizeprice =    $getProductSize->price;
        $quantity = $request->quantity;

        $unitPrice = ($basePrice + $sizeprice) * $quantity;
        Cart::update($request->idCart, array(
            'quantity' => array(
                'relative' => false,
                'value' => $request->quantity
            ),

        ));


        $totalAmountCart = number_format(Cart::getSubTotal(), 0, ',', '.');

        return response()->json(['success' => true, 'amountPrice' => $totalAmountCart, 'unitPrice' => $unitPrice]);
    }
    public function execPostRequest($url, $data) // hàm phụ vụ cho thanh toán momo
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt(
            $ch,
            CURLOPT_HTTPHEADER,
            array(
                'Content-Type: application/json',
                'Content-Length: ' . strlen($data)
            )
        );
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
        //execute post
        $result = curl_exec($ch);
        //close connection
        curl_close($ch);
        return $result;
    }

    // checkout
    public function checkout()
    {
        $getShipping = ShippingModel::getRecord();
        $meta_title = 'Thanh toán';
        $meta_description = '';
        $meta_keywords = '';
        return view('client.payment.checkout', [
            'meta_title' => $meta_title,
            'meta_description' => $meta_description,
            'meta_keywords' => $meta_keywords,
            'getShipping' => $getShipping
        ]);
    }

    public function apply_discount(Request $request)
    {
        $discountValue = DiscountModel::checkDiscount($request->discountCode);
        if (!empty($discountValue)) {
            $discountAmount = 0;
            $discount_percent = 0;
            $total = Cart::getSubTotal();
            if ($discountValue->type == 'Amount') {
                $discountAmount = $discountValue->percen_amount;
                $totalPayment = $total - $discountAmount;
            } else {
                $discount_percent = $discountValue->percen_amount;
                $discountAmount = ($total * $discountValue->percen_amount) / 100;
                $totalPayment = $total - $discountAmount;
            }
            $json['discount_amount'] = number_format($discountAmount, 0, ',', '.');
            $json['discount_percent'] = $discount_percent;
            $json['totalPayment'] = $totalPayment;
            $json['status'] = true;
            $json['message'] = 'Áp dụng thành công';
        } else {
            $json['totalPayment'] = Cart::getSubTotal();
            $json['discount_amount'] = 0;
            $json['status'] = false;
            $json['message'] = 'Mã giảm giá không tồn tại';
        }
        echo json_encode($json);
    }

    public function checkoutPlaceOrder(Request $request)
    {
        $error = true;
        $message = '';
        $user_id = NULL;
        if (!empty(Auth::check())) {
            $user_id = Auth::user()->id;
        } else {
            if (!empty($request->create_account_checkout)) {
                $checkEmail = User::checkEmail($request->email);
                if (!empty($checkEmail)) {
                    $message = "Email đã tồn tại, vui lòng chọn mail khác";
                    $error = false;
                } else {
                    $user = new User;
                    $user->name = $request->lastName;
                    $user->email = $request->email;
                    $user->password = Hash::make($request->password);
                    $user->save();

                    $user_id = $user->id;
                }
            } else {
                $user_id = NULL;
            }
        }
        if ($error) {
            $discountAmount = 0;
            $totalPayAble = Cart::getSubTotal();
            if (!empty($request->discountCode)) {
                $getDiscount = DiscountModel::checkDiscount($request->discountCode);
                if (!empty($getDiscount)) {
                    if ($getDiscount->type == 'Amount' && $getDiscount->type != NULL) {
                        $discountAmount = $getDiscount->percen_amount;
                        $totalPayAble = $totalPayAble - $discountAmount;
                    } else {
                        $discountAmount = ($totalPayAble * $getDiscount->percen_amount) / 100;
                        $totalPayAble = $totalPayAble - $discountAmount;
                    }
                }
            }

            if (!empty($request->shipping)) {
                $getShipping = ShippingModel::find($request->shipping);
                $shippingAmount = $getShipping->price;
                $total = $totalPayAble + $shippingAmount;
            }
            $order_id = rand();
            Session::put(
                'order',
                [
                    'id' => $order_id,
                    'user_id' => $user_id,
                    'firstName' => $request->firstName,
                    'lastName' => $request->lastName,
                    'address' => $request->address,
                    'email' => $request->email,
                    'phone' => $request->phone,
                    'note' => $request->note,
                    'discount_code' => $request->discountCode,
                    'discount_amount' => $discountAmount,
                    'shipping_id' => $request->shipping,
                    'shipping_amount' => $shippingAmount,
                    'total_amount' => $total,
                    'payment_method' => $request->payment_method,

                ]
            );

            $orderItems_session = [];
            foreach (Cart::getContent() as $key => $item) {

                // $order_item = new OrderItemModel;


                $orderItem_session = [
                    'quantity' => $item->quantity,
                    'price' => $item->price,
                    'product_id' => $item->attributes->product_id,

                ];
                $size_id = $item->attributes->size_id;
                if (!empty($size_id)) {
                    $getSize = ProductSizeModel::find($size_id);
                    if (!empty($getSize)) {
                        $orderItem_session['size_name'] = $getSize->name;
                        $orderItem_session['size_amount'] = $getSize->price;
                    }
                }
                $color_id = $item->attributes->color_id;
                if (!empty($color_id)) {
                    $getColor = ColorModel::find($color_id);
                    if ($getColor) {
                        $orderItem_session['color_name'] = $getColor->name;
                    }
                }
                $orderItem_session['total_price'] = $item->price;
                $orderItems_session[] = $orderItem_session;
            }
            Session::put('orderItems_session', $orderItems_session);

            $json['status'] = true;
            $json['message'] = "Thành công";
            $json['redirect'] = url('checkout/payment/?order_id=' . base64_encode(Session::get('order')['id']));
        } else {
            $json['status'] = false;
            $json['message'] = $message;
        }
        echo json_encode($json);
    }
    public function insert_order_detail($order_id)
    {
        $orderItems_session = Session::get('orderItems_session');
        $statistical = new statistical;
        $order =  OrdersModel::find($order_id);

        foreach ($orderItems_session as $orderItem_session) {
            $order_item = new OrderItemModel;
            $order_item->order_id = $order_id;
            $order_item->product_id = $orderItem_session['product_id'];
            $order_item->price = $orderItem_session['price'];
            $order_item->color_name = $orderItem_session['color_name'];
            $order_item->size_name = $orderItem_session['size_name'];
            $order_item->size_amount = $orderItem_session['size_amount'];
            $order_item->quantity = $orderItem_session['quantity'];
            $order_item->total_price = $orderItem_session['total_price'];
            $order_item->save();
        }

        $quantityStatistical = OrderItemModel::getOrderItem($order_id)->count();
        $statistical->quantity = $quantityStatistical;
        $statistical->order_date = now()->format('Y-m-d');
        $totalOrderCurrentDay = OrdersModel::totalTodayOrder();
        $statistical->total_order = $totalOrderCurrentDay;
        $statistical->sales = $order->total_amount;
        $statistical->save();
    }
    public function checkoutPayment(Request $request)
    {

        $order = new OrdersModel;
        if (!empty(Cart::getSubTotal()) && !empty($request->order_id)) {

            $order_id = base64_decode($request->order_id);
            $session_order = Session::get('order');



            if ($session_order['id'] == $order_id) {
                if ($session_order['payment_method'] == 'Tiền mặt') {
                    // Session::put('order', $session_order);
                    $discountValue = DiscountModel::checkDiscount($session_order['discount_code']);


                    $order->id = $session_order['id'];
                    $order->user_id = $session_order['user_id'];
                    $order->firstName = $session_order['firstName'];
                    $order->lastName = $session_order['lastName'];
                    $order->address = $session_order['address'];
                    $order->email = $session_order['email'];
                    $order->phone = $session_order['phone'];
                    $order->note = $session_order['note'];
                    $order->discount_code = !empty($discountValue) ? $discountValue->name : NULL;
                    $order->payment_method = $session_order['payment_method'];
                    $order->discount_amount = $session_order['discount_amount'];
                    $order->shipping_id = $session_order['shipping_id'];
                    $order->shipping_amount = $session_order['shipping_amount'];
                    $order->total_amount = $session_order['total_amount'];
                    $order->is_payment = 0;
                    $order->save();

                    $this->insert_order_detail($session_order['id']);
                    Cart::clear();
                    OrderSuccess::dispatch($order);
                    return redirect('cart')->with('success', 'Đặt hàng thành công');
                } else if ($session_order['payment_method'] == 'Vnpay') {

                    error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED);
                    date_default_timezone_set('Asia/Ho_Chi_Minh');

                    $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
                    $vnp_Returnurl = "http://127.0.0.1:8000/payment_success";
                    $vnp_TmnCode = "U1O190H6"; //Mã website tại VNPAY 
                    $vnp_HashSecret = "PWHVECGGWZPNBSQLHRNJVJGYBOSYMPOV"; //Chuỗi bí mật

                    $vnp_TxnRef = $session_order['id']; //Mã đơn hàng. Trong thực tế Merchant cần insert đơn hàng vào DB và gửi mã này 
                    $vnp_OrderInfo = 'Thanh toán hóa đơn';
                    $vnp_OrderType = 'QK-Shop';
                    $vnp_Amount = $session_order['total_amount'] * 100;
                    $vnp_Locale = 'VN';
                    $vnp_BankCode = 'NCB';
                    $vnp_IpAddr = $_SERVER['REMOTE_ADDR'];
                    //Add Params of 2.0.1 Version
                    //Billing

                    $inputData = array(
                        "vnp_Version" => "2.1.0",
                        "vnp_TmnCode" => $vnp_TmnCode,
                        "vnp_Amount" => $vnp_Amount,

                        "vnp_Command" => "pay",
                        "vnp_CreateDate" => date('YmdHis'),
                        "vnp_CurrCode" => "VND",
                        "vnp_IpAddr" => $vnp_IpAddr,
                        "vnp_Locale" => $vnp_Locale,
                        "vnp_OrderInfo" => $vnp_OrderInfo,
                        "vnp_OrderType" => $vnp_OrderType,
                        "vnp_ReturnUrl" => $vnp_Returnurl,
                        "vnp_TxnRef" => $vnp_TxnRef,
                    );

                    if (isset($vnp_BankCode) && $vnp_BankCode != "") {
                        $inputData['vnp_BankCode'] = $vnp_BankCode;
                    }
                    if (isset($vnp_Bill_State) && $vnp_Bill_State != "") {
                        $inputData['vnp_Bill_State'] = $vnp_Bill_State;
                    }

                    //var_dump($inputData);
                    ksort($inputData);
                    $query = "";
                    $i = 0;
                    $hashdata = "";
                    foreach ($inputData as $key => $value) {
                        if ($i == 1) {
                            $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
                        } else {
                            $hashdata .= urlencode($key) . "=" . urlencode($value);
                            $i = 1;
                        }
                        $query .= urlencode($key) . "=" . urlencode($value) . '&';
                    }

                    $vnp_Url = $vnp_Url . "?" . $query;
                    if (isset($vnp_HashSecret)) {
                        $vnpSecureHash =   hash_hmac('sha512', $hashdata, $vnp_HashSecret); //  
                        $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
                    }
                    $returnData = array(
                        'code' => '00', 'message' => 'success', 'data' => $vnp_Url
                    );
                    if ($session_order['payment_method'] == 'Vnpay') {
                        header('Location: ' . $vnp_Url);
                        die();
                    } else {
                        echo json_encode($returnData);
                    }
                    // vui lòng tham khảo thêm tại code demo
                    session(['status' => false]);
                } else if ($session_order['payment_method'] == 'Momo') {
                    // if ($getOrder->is_payment == 0) {
                    //     $getOrder->delete();
                    //     $getOrder -> deleteOrderItem();
                    //     // Tiếp tục các bước khác sau khi xóa đơn hàng
                    // }
                    $endpoint = "https://test-payment.momo.vn/v2/gateway/api/create";
                    $partnerCode = 'MOMOBKUN20180529';
                    $accessKey = 'klm05TvNBzhg7h7j';
                    $secretKey = 'at67qH6mk8w5Y1nAyMoYKMWACiEi2bsa';
                    $orderInfo = "Thanh toán qua MoMo";
                    $amount = $session_order['total_amount'];
                    $orderId = $session_order['id'];

                    $redirectUrl = "http://127.0.0.1:8000/payment_success";
                    $ipnUrl = "http://127.0.0.1:8000/payment_success";
                    $extraData = "";

                    $requestId = time() . "";
                    $requestType = "payWithATM";
                    $rawHash = "accessKey=" . $accessKey . "&amount=" . $amount . "&extraData=" . $extraData . "&ipnUrl=" . $ipnUrl . "&orderId=" . $orderId . "&orderInfo=" . $orderInfo . "&partnerCode=" . $partnerCode . "&redirectUrl=" . $redirectUrl . "&requestId=" . $requestId . "&requestType=" . $requestType;
                    $signature = hash_hmac("sha256", $rawHash, $secretKey);

                    $data = array(
                        'partnerCode' => $partnerCode,
                        'partnerName' => "Test",
                        "storeId" => "MomoTestStore",
                        'requestId' => $requestId,
                        'amount' => $amount,
                        'orderId' => $orderId,
                        'orderInfo' => $orderInfo,
                        'redirectUrl' => $redirectUrl,
                        'ipnUrl' => $ipnUrl,
                        'lang' => 'vi',
                        'extraData' => $extraData,
                        'requestType' => $requestType,
                        'signature' => $signature
                    );

                    $result = $this->execPostRequest($endpoint, json_encode($data));

                    // Log or print the result for debugging
                    file_put_contents('momo_api_response.log', $result);

                    $jsonResult = json_decode($result, true);  // decode json

                    // Check if 'payUrl' exists in the response
                    if (isset($jsonResult['payUrl'])) {
                        return redirect()->to($jsonResult['payUrl']);
                    } else {
                        // Log or handle the error if 'payUrl' is not found
                        file_put_contents('momo_api_error.log', 'payUrl not found in response: ' . $result);
                        return redirect()->to('http://127.0.0.1:8000/payment_error');  // Redirect to an error page or handle it accordingly
                    }
                }
            }







            // dd($orderItems_session);


        }
    }

    public function payment_success(Request $request)
    {
        $order = new OrdersModel;

        if (!empty($request->vnp_TxnRef) && ($request->vnp_ResponseCode  == '00') && ($request->vnp_TransactionStatus  == '00')) {

            if ($session_order = Session::get('order')['id'] == $request->vnp_TxnRef) {
                $session_order =  Session::get('order');
                $discountValue = DiscountModel::checkDiscount($session_order['discount_code']);
                $order->id = $request->vnp_TxnRef;
                $order->user_id = $session_order['user_id'];
                $order->firstName = $session_order['firstName'];
                $order->lastName = $session_order['lastName'];
                $order->address = $session_order['address'];
                $order->email = $session_order['email'];
                $order->phone = $session_order['phone'];
                $order->note = $session_order['note'];
                $order->discount_code = !empty($discountValue) ? $discountValue->name : NULL;
                $order->payment_method = $session_order['payment_method'];
                $order->discount_amount = $session_order['discount_amount'];
                $order->shipping_id = $session_order['shipping_id'];
                $order->shipping_amount = $session_order['shipping_amount'];
                $order->total_amount = $session_order['total_amount'];
                $order->is_payment = 1;
                $order->payment_data = json_encode($request->all());
                $order->save();
                $this->insert_order_detail($request->vnp_TxnRef);
                Cart::clear();
                OrderSuccess::dispatch($order);
                return redirect('cart')->with('success', 'Thanh toán Momo thành công');
            }
        }

        if ($request->resultCode  == '0' && $request->message == 'Successful.') {
            if ($session_order = Session::get('order')['id'] == $request->orderId) {
                $session_order =  Session::get('order');
                $discountValue = DiscountModel::checkDiscount($session_order['discount_code']);
                $order->id = $request->orderId;
                $order->user_id = $session_order['user_id'];
                $order->firstName = $session_order['firstName'];
                $order->lastName = $session_order['lastName'];
                $order->address = $session_order['address'];
                $order->email = $session_order['email'];
                $order->phone = $session_order['phone'];
                $order->note = $session_order['note'];
                $order->discount_code = !empty($discountValue) ? $discountValue->name : NULL;
                $order->payment_method = $session_order['payment_method'];
                $order->discount_amount = $session_order['discount_amount'];
                $order->shipping_id = $session_order['shipping_id'];
                $order->shipping_amount = $session_order['shipping_amount'];
                $order->total_amount = $session_order['total_amount'];
                $order->is_payment = 1;
                $order->payment_data = json_encode($request->all());
                $order->save();
                $this->insert_order_detail($request->orderId);
                Cart::clear();
                OrderSuccess::dispatch($order);
                return redirect('cart')->with('success', 'Thanh toán Momo thành công');
            }
        }
    }
}
