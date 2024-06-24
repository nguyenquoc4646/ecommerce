@extends('admin.layouts.app')
@section('title')
    Cập nhật sản phẩm
@endsection
@section('style')
    <link rel="stylesheet" href="/assets_admin/plugins/summernote/summernote-bs4.min.css">
@endsection
@section('content')
    <div class="content-wrapper">
        <div class="content">
            <div class="container-fluid">
                @include('admin.layouts._message')
                <!-- /.row -->
                <div class="row">
                    <div class="col-12">
                        <div class="row mb-2 mt-2 d-flex justify-between">
                            <div class="col-sm-6">
                                <h5>Cập nhật sản phẩm : {{ $data->title }}</h5>
                            </div>

                        </div>
                        <div class="card card-primary">
                            <form action="" method="post" enctype="multipart/form-data">
                                {{ csrf_field() }}
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Tiêu đề <span class="text-danger">*</span>
                                                </label>
                                                <input type="text" name="title"
                                                    value="{{ old('title', $data->title) }}" class="form-control"
                                                    id="exampleInputEmail1" placeholder="Nhập sản phẩm ...">
                                                <div class="text-danger">{{ $errors->first('title') }}</div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">SKU <span class="text-danger">*</span>
                                                </label>
                                                <input type="text" name="sku" value="{{ old('sku', $data->sku) }}"
                                                    class="form-control" id="exampleInputEmail1" placeholder="Sku ...">
                                                <div class="text-danger">{{ $errors->first('sku') }}</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Danh mục <span class="text-danger">*</span>
                                                </label>
                                                <select name="category" id="changeCategory" class="form-control">
                                                    @foreach ($category as $item)
                                                        <option value="{{ $item->id }}"
                                                            {{ $item->id == $data->category_id ? 'selected' : '' }}>
                                                            {{ $item->name }}</option>
                                                    @endforeach

                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Danh mục phụ <span
                                                        class="text-danger">*</span>
                                                </label>
                                                <select name="subCategory" id="getSubcategory" class="form-control">
                                                    @foreach ($subCategory as $item)
                                                        <option value="{{ $item->id }}"
                                                            {{ $data->sub_category_id == $item->id ? 'selected' : '' }}>
                                                            {{ $item->name }}</option>
                                                    @endforeach
                                                </select>
                                                <div class="text-danger">{{ $errors->first('subCategory') }}</div>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Thương hiệu <span
                                                        class="text-danger">*</span>
                                                </label>
                                                <select name="brand" class="form-control">
                                                    @foreach ($brand as $item)
                                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                                    @endforeach

                                                </select>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Màu sắc<span class="text-danger">*</span>
                                                </label>
                                                @foreach ($color as $item)
                                                    @php
                                                        $checked = '';
                                                    @endphp
                                                    @foreach ($data->checkedColor as $p_color)
                                                        @if ($p_color->color_id == $item->id)
                                                            @php
                                                                $checked = 'checked';
                                                            @endphp
                                                        @endif
                                                    @endforeach
                                                    <div>
                                                        <label for="">
                                                            <input {{ $checked }} type="checkbox" name="color_id[]"
                                                                id="" value="{{ $item->id }}">
                                                            {{ $item->name }}</label>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>

                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Xu hướng <span class="text-danger">*</span>
                                                </label>
                                                <input type="checkbox" name="is_trendy"
                                                    {{ !empty($data->is_trendy) ? 'checked' : '' }}>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Kích cỡ<span class="text-danger">*</span>
                                                </label>
                                                <div>
                                                    <table class="table table-striped">
                                                        <thead>
                                                            <th>Cỡ</th>
                                                            <th>Giá</th>
                                                            <th>Hành động</th>
                                                        </thead>
                                                        <tbody class="appendSize">

                                                            @foreach ($data->checkedSize as $item)
                                                                @php
                                                                    $i_size = 1;
                                                                @endphp
                                                                <tr id="deleteSize{{ $i_size }}">
                                                                    <td>
                                                                        <input value="{{ $item->name }}" type="text"
                                                                            name="size[{{ $i_size }}][name]"
                                                                            class="form-control" placeholder="Name...">
                                                                    </td>
                                                                    <td>
                                                                        <input value="{{ $item->price }}" type="text"
                                                                            name="size[{{ $i_size }}][price]"
                                                                            class="form-control" placeholder="Price...">
                                                                    </td>
                                                                    <td>
                                                                        <input value="{{ $item->amount }}" type="number"
                                                                            name="size[{{ $i_size }}][amount]"
                                                                            class="form-control"
                                                                            placeholder="số lượng...">
                                                                    </td>
                                                                    <td>

                                                                        <button type="button" id="{{ $i_size }}"
                                                                            class="btn btn-danger btn-sm deleteSize">Xóa</button>
                                                                    </td>


                                                                </tr>
                                                                @php
                                                                    $i_size++;
                                                                @endphp
                                                            @endforeach
                                                            <tr>
                                                                <td>
                                                                    <input type="text" name="size[100][name]"
                                                                        class="form-control" placeholder="Name...">
                                                                </td>
                                                                <td>
                                                                    <input type="text" name="size[100][price]"
                                                                        class="form-control" placeholder="Price...">
                                                                </td>
                                                                <td>
                                                                    <input type="number" name="size[100][amount]"
                                                                        class="form-control" placeholder="số lượng...">
                                                                </td>
                                                                <td>
                                                                    <button type="button"
                                                                        class="btn btn-primary btn-sm addSize">Thêm</button>
                                                                </td>
                                                            </tr>

                                                        </tbody>
                                                    </table>
                                                </div>

                                            </div>
                                        </div>

                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Giá <span class="text-danger">*</span>
                                                </label>
                                                <input type="text" name="price"
                                                    value="{{ old('price', $data->price) }}" class="form-control"
                                                    id="exampleInputEmail1" placeholder="Nhập sản phẩm ...">
                                                <div class="text-danger">{{ $errors->first('price') }}</div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Giá cũ <span class="text-danger">*</span>
                                                </label>
                                                <input type="text" name="oldPrice"
                                                    value="{{ old('oldPrice', $data->old_price) }}" class="form-control"
                                                    id="exampleInputEmail1" placeholder="Giá cũ ...">
                                                <div class="text-danger">{{ $errors->first('oldPrice') }}</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Hình ảnh: <span
                                                        class="text-danger">*</span>
                                                </label>
                                                <input style="padding: 3px" type="file" name="image[]" multiple
                                                    class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                    @if (!empty($data->getImageByIdPro->count()))
                                        <div class="row" id="sortable">
                                            @foreach ($data->getImageByIdPro as $item)
                                                <div class="col-md-2 text-center sortable_image"
                                                    id="{{ $item->id }}">
                                                    @if (!empty($item->getImage()))
                                                        <img src="{{ $item->getImage() }}"
                                                            style="width:120px;height:120px;" alt="">
                                                        <a href="{{ url('admin/product/delete_image/' . $item->id) }}"
                                                            class="btn btn-danger btn-sm mt-2">Xóa</a>
                                                    @endif
                                                </div>
                                            @endforeach

                                        </div>
                                    @endif
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Mô tả ngắn <span
                                                        class="text-danger">*</span>
                                                </label>

                                                <textarea placeholder="Mô tả ngắn .." name="short_description" class="form-control">
                                                    {{ $data->short_description }}
                                               </textarea>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Mô tả <span class="text-danger">*</span>
                                                </label>
                                                <textarea placeholder="Mô tả .." name="description" class="form-control editor">
                                                    {{ $data->description }}
                                               </textarea>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Thông tin bổ sung<span
                                                        class="text-danger">*</span>
                                                </label>
                                                <textarea placeholder="Thông tin bổ sung .." name="additional_description" class="form-control editor">
                                                    {{ $data->additional_description }}
                                               </textarea>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Giao hàng & hoàn trả<span
                                                        class="text-danger">*</span>
                                                </label>
                                                <textarea placeholder="Giao hàng & hoàn trả .." name="shipping_return" class="form-control editor">
                                                    {{ $data->shipping_return }}
                                               </textarea>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Trạng thái<span
                                                        class="text-danger">*</span>
                                                </label>
                                                <select name="status" class="form-control">
                                                    <option value="0" {{ $data->status == 0 ? 'selected' : '' }}>
                                                        Hoạt
                                                        động
                                                    </option>
                                                    <option value="1" {{ $data->status == 1 ? 'selected' : '' }}>
                                                        Không hoạt
                                                        động
                                                    </option>
                                                </select>
                                            </div>
                                        </div>

                                    </div>




                                </div>
                                <!-- /.card-body -->

                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary">Cập nhật</button>
                                </div>
                            </form>
                        </div>
                        <!-- /.card-body -->

                        <!-- /.card -->
                    </div>
                </div>
                <!-- /.row -->

                <!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
    </div>
@endsection
@section('script')
    <script src="/assets_admin/plugins/summernote/summernote-bs4.min.js"></script>
    <script src="/assets_admin/sortable/jquery-ui.js"></script>
    <script>
        $(document).ready(function() {
            $(function() {
                $("#sortable").sortable({
                    update: function(event, ui) {
                        var image_id = new Array();
                        $('.sortable_image').each(function() {
                            var id = $(this).attr('id')
                            image_id.push(id)
                        });

                        console.log(image_id);

                        $.ajax({
                            type: "POST",
                            url: "{{ url('admin/product_image_sortable') }}",
                            data: {
                                'image_id': image_id,
                                "_token": "{{ csrf_token() }}"
                            },
                            dataType: "json",
                            success: function(data) {

                            }
                        })
                    }
                });
            });
        })
    </script>

    <script>
        $(function() {
            // Summernote
            $('.editor').summernote({
                height: 200
            })

            // CodeMirror

        })
    </script>
    <script type="text/javascript">
        var i = 101
        $('body').delegate('.addSize', 'click', function() {
            var html = '<tr id="deleteSize' + i + '">' +
                '<td><input type="text" placeholder="Size..." name="size[' + i +
                '][name]" class="form-control"></td>' +
                '<td><input name="size[' + i +
                '][price]" type="text" placeholder="Price..." class="form-control"></td>' +
                '<td><input type="number" placeholder="số lượng..." name="size[' + i +
                '][amount]" class="form-control"></td>' +

                '<td><button type="button" id="' + i +
                '" class="btn btn-danger btn-sm deleteSize">Xóa</button></td>' +
                '</tr>';
            i++
            $('.appendSize').append(html)
        })

        $('body').delegate('.deleteSize', 'click', function() {
            var id = $(this).attr('id')
            $('#deleteSize' + id).remove()
        })
        $('body').delegate('#changeCategory', 'change', function(e) {
            var id = $(this).val();
            $.ajax({

                type: "POST",
                url: "{{ url('admin/get_sub_category') }}",
                data: {
                    "id": id, // Đảm bảo bạn đã có giá trị thực của biến id ở đây
                    "_token": "{{ csrf_token() }}"
                },
                dataType: 'json',
                success: function(data) {

                    $('#getSubcategory').html(data.html);
                },
                error: function(data) {}

            })
        })
    </script>
@endsection
