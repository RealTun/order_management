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
        {{-- @if (session('success'))
            <div class="alert alert-success ">
                {{ session('success') }}
            </div>
        @endif --}}
        <div class="row">
            @if (session('errors'))
                <div class="alert alert-danger ">
                    @foreach ($errors as $error)
                        {{ $error }}
                    @endforeach
                </div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger ">
                    {{ session('error') }}
                </div>
                <script>
                    setTimeout(() => {
                        window.location.reload(); 
                    }, 2000);
                </script>
            @endif
        </div>
        <div class="row border border-dark">
            <h3 class="text-center m-3">HOÁ ĐƠN BÁN HÀNG</h3>
        </div>
        <div class="row">
            <form action="{{ route('orders.store') }}" id="form" class="" method="post">
                @csrf
                <div class="row p-3 border border-dark">
                    <h5>Thông tin khách hàng</h5>
                    <div class="row">
                        @php
                            if (session()->has('customer')) {
                                $customer = session('customer');
                            }
                        @endphp
                        <div class="input-group mb-3 mt-3 col">
                            <span class="input-group-text" id="basic-addon1">Tên khách hàng</span>
                            @if (session('customer'))
                                <input type="text" class="form-control" id="tenkh" name="tenkh"
                                    value="{{ $customer[0] }}">
                            @else
                                <input type="text" class="form-control" id="tenkh" name="tenkh" required>
                            @endif
                        </div>
                        <div class="input-group mb-3 mt-3 col">
                            <span class="input-group-text" id="basic-addon1">Địa chỉ</span>

                            @if (session('customer'))
                                <input type="text" class="form-control" id="diachi" name="diachi"
                                    value="{{ $customer[1] }}">
                            @else
                                <input type="text" class="form-control" id="diachi" name="diachi" required>
                            @endif
                        </div>
                        <div class="input-group mb-3 mt-3 col">
                            <span class="input-group-text" id="basic-addon1">Số điện thoại</span>
                            @if (session('customer'))
                                <input type="text" class="form-control" id="dienthoai" name="dienthoai"
                                    value="{{ $customer[2] }}">
                            @else
                                <input type="text" class="form-control" id="dienthoai" name="dienthoai" required>
                            @endif
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
                    <table class="table" id="table-order">
                        <thead class="text-center">
                            <tr>
                                <th scope="col">Loại hàng</th>
                                <th scope="col">Tên hàng hoá</th>
                                <th scope="col">Đơn vị tính</th>
                                <th scope="col">Số lượng</th>
                                <th scope="col">Đơn giá</th>
                                <th scope="col">Thành tiền</th>
                            </tr>
                        </thead>
                        <tbody class="text-center">
                            @if (session('table'))
                                @foreach (session('table') as $id => $details)
                                    <tr>
                                        <td>{{ $details['type'] }}</td>
                                        <td>{{ $details['product_name'] }}</td>
                                        <td>{{ $details['unit'] }}</td>
                                        <td>{{ $details['quantity'] }}</td>
                                        <td>${{ $details['price'] }}</td>
                                        <td>${{ $details['quantity'] * $details['price'] }}</td>
                                        <td><button class="btn btn-danger btn-sm" data-id="{{ $id }}"><i
                                                    class="fa-solid fa-trash"></i></button></td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>

                </div>
                <div class="d-flex m-3 justify-content-end">
                    <input type="submit" id="btnAdd" value="Xác nhận" class="btn btn-success">
                </div>
            </form>
        </div>
    </main>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script>
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

            $('#btn-add-table').click(function() {
                var type = $('#select1 option:selected').text();
                var id_product = $('#select2 option:selected').val();
                var product = $('#select2 option:selected').text();
                var quantity = $('#quantity').val();
                var unit = $('#unit').val();
                var price = $('#price').val();
                var total = Number(price) * Number(quantity);
                var nameCus = $('#tenkh').val();
                var address = $('#diachi').val();
                var phone = $('#dienthoai').val();

                if (type !== '' && product !== '' && quantity !== '' && nameCus !== '' && address !== '' &&
                    phone !== '') {
                    var row = [type, product, unit, quantity, price, total];
                    var customer = [nameCus, address, phone];

                    $.ajax({
                        url: '/saveTable',
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data: {
                            row: row,
                            id_product: id_product,
                            customer: customer
                        },
                        success: function(response) {
                            window.location.reload();
                        },
                        error: function(xhr, status, error) {
                            // Handle the error if needed
                        }
                    });
                    $('#quantity').val(''); // Clear the input field
                }
            });

            $('.btn-danger').click(function(e) {
                e.preventDefault();
                id_product = $(this).data('id');
                $.ajax({
                    url: '/remove',
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        id_product: id_product,
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
