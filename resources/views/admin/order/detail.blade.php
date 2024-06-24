@extends('admin.layouts.app')
@section('title')
    Chi tiết đơn hàng
@endsection
@section('content')
    <div class="content-wrapper">
        <div class="content">
            <div class="container-fluid">

                <!-- /.row -->
                <div class="row">
                    <div class="cart">
                        <div class="cart-header">
                            <h4>Chi tiết đơn hàng</h4>
                           
                        </div>
                       
                    </div>
                   
                    <div class="col-12">
                        <div class="card card-primary">
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="">Id: </label>{{ $data->id }}
                                     <a  href="{{ url('orderDetailPdf/'.$data->id ) }}" class="btn btn-primary">in PDF</a>
                                </div>
                                <div class="form-group">
                                    <label for="">Người nhận : </label>{{ $data->lastName }}
                                </div>
                                <div class="form-group">
                                    <label for="">Địa chỉ : </label>{{ $data->address }}
                                </div>
                                <div class="form-group">
                                    <label for="">Email : </label>{{ $data->email }}
                                </div>
                                <div class="form-group">
                                    <label for="">Số điện thoại : </label>{{ $data->phone }}
                                </div>
                                <div class="form-group">
                                    <label for="">Ghi chú : </label>{{ $data->note }}
                                </div>
                                @if (!empty($data->discount_code))
                                    <div class="form-group">
                                        <label for="">Mã giảm giá : </label>{{ $data->discount_code }}
                                    </div>
                                @endif
                                @if (!empty($data->discount_amount))
                                    <div class="form-group">
                                        <label for="">Số tiền giảm giá : </label>{{ number_format($data->discount_amount, 0, ',', '.') }}VNĐ
                                    </div>
                                @endif

                                <div class="form-group">
                                    <label for="">Hình thức vận chuyển : </label>{{ $data->getShipping->name }}
                                </div>
                                <div class="form-group">
                                    <label for="">Phí vận chuyển : </label>{{ number_format($data->shipping_amount, 0, ',', '.') }}VNĐ
                                </div>
                                <div class="form-group">
                                    <label for="">Phương thức thanh toán : </label>{{ $data->payment_method }}
                                </div>
                                <div class="form-group">
                                    <label for="">Tổng tiền : </label>{{ number_format($data->total_amount, 0, ',', '.') }}VNĐ
                                </div>
                                <div class="form-group">
                                    <label for="">Trạng thái vận chuyển : </label>{{ $data->status }}
                                </div>
                                <div class="form-group">
                                    <label for="">Trạng thái thanh toán :
                                    </label>{{ $data->is_payment == 1 ? 'Đã thanh toán' : 'Chưa thanh toán' }}
                                </div>
                                <div class="form-group">
                                    <label for="">Ngày đặt : </label>{{ $data->created_at }}
                                </div>
                            </div>
                        </div>

                        <!-- /.card-body -->

                        <!-- /.card -->
                    </div>
                </div>
                <div class="card">

                    <div class="card-body table-responsive p-0" style="height: 300px;">
                        <table class="table table-head-fixed text-nowrap table-striped">
                            <thead>
                                <tr>
                                    <th>Hình ảnh</th>
                                    <th>Tên sản phẩm</th>
                                    <th>Số lượng</th>
                                    <th>Giá</th>
                                    <th>Kích cỡ</th>
                                    <th>Màu sắc</th>
                                    <th>Giá size</th>
                                    <th>Thành tiền</th>
                                </tr>
                            </thead>
                            <tbody>

                                @foreach ($data->getOrderItem as $item)
                                @php
                                        $getImage = $item->getProduct->getImageByIdProClient($item->getProduct->id);
                                    @endphp
                                    <tr>
                                        {{-- <td><img src="{{ $item->getProduct->name }}" alt=""></td> --}}
                                        <td><img style="width:100px;" src="{{ $getImage->getImage() }}" alt=""></td>
                                        <td>{{ $item->getProduct->title }}</td>
                                        <td>{{ $item->quantity }}</td>                                              
                                        <td>{{ number_format($item->price, 0, ',', '.') }}VNĐ</td>
                                         <td>{{ $item->size_name }}</td>
                                         <td>{{ $item->color_name }}</td>
                                         <td>{{ number_format($item->size_amount, 0, ',', '.') }}VNĐ</td>
                                         <td>{{ number_format($item->total_price, 0, ',', '.') }}VNĐ</td>
                                         
                                       
                                    </tr>
                                @endforeach


                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- /.row -->

                <!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
    </div>
@endsection
