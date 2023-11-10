@extends('layouts.base')

@section('title')
    Đơn hàng
@endsection

@section('page_active')
    <li class="nav-item">
        <a class="nav-link" href="">Trang chủ</a>
    </li>
    <li class="nav-item">
        <a class="nav-link active" href="">Hoá đơn</a>
    </li>
@endsection

@section('main')
    <main class="container vh-100 mt-5 ">
        <div class="toast-container position-fixed top-0 end-0 p-3">
            <div class="toast" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="toast-header">
                    <strong class="me-auto">Notification</strong>
                    <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
                <div class="toast-body">
                    Update quantity successful
                </div>
            </div>
        </div>
        <div class="row border border-dark">
            <h3 class="text-center m-3">HOÁ ĐƠN SỐ {{ $order_customer->ma_hoadon }}</h3>
        </div>
        <div class="row">
            <form action="{{ route('orders.update', $order_customer->ma_hoadon) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="row p-3 border border-dark">
                    <h5>Thông tin khách hàng</h5>
                    <div class="row">
                        <input type="text" class="d-none" id="ma_hoadon" value="{{ $order_customer->ma_hoadon }}">
                        <div class="input-group mb-3 mt-3 col">
                            <span class="input-group-text" id="basic-addon1">Tên khách hàng</span>
                            <input type="text" class="form-control" id="tenkh" name="tenkh"
                                value="{{ $order_customer->ten_kh }}">
                        </div>
                        <div class="input-group mb-3 mt-3 col">
                            <span class="input-group-text" id="basic-addon1">Địa chỉ</span>
                            <input type="text" class="form-control" id="diachi" name="diachi"
                                value="{{ $order_customer->diachi }}">
                        </div>
                        <div class="input-group mb-3 mt-3 col">
                            <span class="input-group-text" id="basic-addon1">Số điện thoại</span>
                            <input type="text" class="form-control" id="dienthoai" name="dienthoai"
                                value="{{ $order_customer->dienthoai }}">
                        </div>
                    </div>

                </div>
                <div class="row p-3 border border-dark">
                    <h5>Thông tin sản phẩm</h5>
                    <div class="row">
                        <div class="input-group mt-3 mb-3 col">
                            <label class="input-group-text" for="select1">Loại hàng</label>
                            <select class="form-select" name="loaihang" id="select1">
                                <option selected disabled>Vui lòng chọn loại mặt hàng</option>
                                @foreach ($type as $item)
                                    <option value="{{ $item->ma_loai }}">{{ $item->ten_loai }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="input-group mt-3 mb-3 col">
                            <label class="input-group-text" for="select2">Sản phẩm</label>
                            <select class="form-select" name="sanpham" id="select2">
                                <option selected disabled>Vui lòng chọn sản phẩm/option>
                            </select>
                        </div>
                        <div class="input-group mb-3 mt-3 col">
                            <span class="input-group-text" id="basic-addon1">Số lượng</span>
                            <input type="number" class="form-control" id="quantity" name="quantity" maxlength="3">
                        </div>
                        <div class="input-group mb-3 mt-3 col d-none">
                            <input type="text" class="form-control" id="unit" name="unit" value=""
                                readonly>
                            <input type="text" class="form-control" id="price" name="price" value=""
                                readonly>
                        </div>

                        <button type="button" class="btn btn-success mb-3 mt-3 col" id="btn-add-table">Thêm sản
                            phẩm</button>
                    </div>
                </div>
                <div class="row p-3 border border-dark">
                    <h5>Chi tiết đơn hàng</h5>
                    <table class="table" id="editableContent">
                        <thead class="text-center">
                            <tr>
                                <th scope="col">Loại hàng</th>
                                <th scope="col">Tên hàng hoá</th>
                                <th scope="col">Đơn vị tính</th>
                                <th scope="col">Số lượng</th>
                                <th scope="col">Đơn giá</th>
                                <th scope="col">Thành tiền</th>
                                <th scope="col">Xoá</th>
                            </tr>
                        </thead>
                        <tbody class="text-center">
                            @foreach ($order as $item)
                                <tr>
                                    <td>{{ $item->ten_loai }}</td>
                                    <td>{{ $item->ten_sp }}</td>
                                    <td>{{ $item->donvi }}</td>
                                    <td class="editableItem" data-item-id="{{ $item->ma_sp }}"
                                        data-price="{{ $item->dongia }}">
                                        {{ $item->soluong }}
                                    </td>
                                    <td>${{ $item->dongia }}</td>
                                    <td id="{{ 'total' . $item->ma_sp }}">${{ $item->soluong * $item->dongia }}</td>
                                    <td><a class="btn btn-danger btn-sm btn-delete" data-item-id="{{ $item->ma_sp }}"><i
                                                class="fa-solid fa-trash"></i></a></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                </div>
                <div class="d-flex mt-3 justify-content-end">
                    {{-- <input type="submit" id="btnUpdate" class="btn btn-success mx-3" value="Cập nhật"> --}}
                    <a href="{{ route('orders.index') }}" class="btn btn-warning">Quay lại</a>
                </div>
            </form>
        </div>
    </main>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#select1').change(function() {
                var selectedType = $(this).val();

                $.ajax({
                    url: '/orders/create/t',
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        selectedType: selectedType,
                    },
                    success: function(response) {
                        // Clear the options in select2
                        $('#select2').empty();

                        // Append the new options to select2
                        $.each(response.options, function(index, option) {
                            $('#select2').append('<option value="' + option.ma_sp +
                                '">' + option.ten_sp + '</option>');
                        });

                        var selectedValue = $('#select2').val();
                        $.ajax({
                            url: '/orders/create/p',
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                                    'content')
                            },
                            data: {
                                selectedValue: selectedValue
                            },
                            success: function(response) {
                                $('#unit').val(response.product.donvi);
                                $('#price').val(response.product.dongia);
                            },
                            error: function(xhr, status, error) {
                                // Handle the error if needed
                            }
                        });
                    },
                    error: function(xhr, status, error) {
                        // Handle the error if needed
                    }
                });
            });

            $('#select2').change(function() {
                var selectedValue = $(this).val();
                $.ajax({
                    url: '/orders/create/p',
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        selectedValue: selectedValue
                    },
                    success: function(response) {
                        $('#unit').val(response.product.donvi);
                        $('#price').val(response.product.dongia);
                    },
                    error: function(xhr, status, error) {
                        // Handle the error if needed
                    }
                });
            })

            var orders = [];
            var list = [];

            $('#btn-add-table').click(function() {
                var order_id = $('#ma_hoadon').val();
                var id_product = $('#select2 option:selected').val();
                var product = $('#select2 option:selected').text();
                var quantity = $('#quantity').val();

                if (product !== '' && quantity !== '') {
                    $.ajax({
                        url: '/addRow',
                        method: 'POST',
                        data: {
                            order_id: order_id,
                            product_id: id_product,
                            quantity: quantity,
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            window.location.reload();
                        },
                        error: function(xhr, status, error) {
                            // Handle error response
                        }
                    });

                    $('#quantity').val(''); // Clear the input field
                }
            });

            $('.editableItem').click(function() {
                $(this).attr('contenteditable', true).focus();
            });

            $('.editableItem').blur(function() {
                var order_id = $('#ma_hoadon').val();
                var itemId = $(this).data('item-id');
                var newValue = $(this).text();
                var price = $(this).data('price');
                $('#total' + itemId).text('$' + Number(newValue) * Number(price));

                $.ajax({
                    url: '/updateop',
                    method: 'POST',
                    data: {
                        order_id: order_id,
                        product_id: itemId,
                        quantity: newValue,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        $('.toast').toast('show');
                    },
                    error: function(xhr, status, error) {
                        // Handle error response
                    }
                });

                $(this).attr('contenteditable', false);
            });

            $('.btn-delete').click(function() {
                var order_id = $('#ma_hoadon').val();
                var itemId = $(this).data('item-id');
                $.ajax({
                    url: '/delete',
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        order_id: order_id,
                        product_id: itemId
                    },
                    success: function(response) {
                        window.location.reload();
                    },
                    error: function(xhr, status, error) {
                        // Handle the error if needed
                    }
                });
            });
        });
    </script>
@endsection
