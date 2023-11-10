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
        <div class="row border border-dark">
            <h3 class="text-center m-3">HOÁ ĐƠN SỐ {{ $order_customer->ma_hoadon }}</h3>
        </div>
        <div class="row">
            <div>
                <div class="row p-3 border border-dark">
                    <h5>Thông tin khách hàng</h5>
                    <div class="row">
                        <div class="input-group mb-3 mt-3 col">
                            <span class="input-group-text" id="basic-addon1">Tên khách hàng</span>
                            <input type="text" class="form-control" id="tenkh" name="tenkh"
                                value="{{ $order_customer->ten_kh }}" readonly>
                        </div>
                        <div class="input-group mb-3 mt-3 col">
                            <span class="input-group-text" id="basic-addon1">Địa chỉ</span>
                            <input type="text" class="form-control" id="diachi" name="diachi"
                                value="{{ $order_customer->diachi }}" readonly>
                        </div>
                        <div class="input-group mb-3 mt-3 col">
                            <span class="input-group-text" id="basic-addon1">Số điện thoại</span>
                            <input type="text" class="form-control" id="dienthoai" name="dienthoai"
                                value="{{ $order_customer->dienthoai }}" readonly>
                        </div>
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
                            @foreach ($order as $item)
                                <tr>
                                    <td>{{ $item->ten_loai }}</td>
                                    <td>{{ $item->ten_sp }}</td>
                                    <td>{{ $item->donvi }}</td>
                                    <td>{{ $item->soluong }}</td>
                                    <td>{{ $item->dongia }}</td>
                                    <td>${{ $item->soluong * $item->dongia }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                </div>
                <div class="d-flex mt-3 justify-content-end">
                    <a href="{{ route('orders.index') }}" class="btn btn-success">Quay lại</a>
                </div>
            </div>
        </div>
    </main>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
@endsection
