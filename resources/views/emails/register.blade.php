@component('mail::message')
 Hi <b>{{ $user->name }}</b>
 <p>Bạn vừa đăng kí tài khoản</p>
 <p>Vui lòng click vào đây để xác minh email của bạn</p>
 @component('mail::button',['url'=>url('http://127.0.0.1:8000/activate/'.base64_encode($user->id))])
 Xác minh
 @endcomponent
 <p>Email của bạn sẽ được các minh ngay</p>
 From: {{ config('mail.from.address') }} ({{ config('mail.from.name') }})
@endcomponent