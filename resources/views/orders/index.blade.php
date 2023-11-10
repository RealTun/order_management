@extends('layouts.base')

@section('title')
    Đơn hàng
@endsection

@section('page_active')
    <li class="nav-item">
        <a class="nav-link" href="">Trang chủ</a>
    </li>
    <div class="dropdown">
        <a class="nav-link active dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
            Hoá đơn
        </a>
        <ul class="dropdown-menu">
            <li><a class="dropdown-item" type="button" href="{{ route('orders.index') }}"">Danh sách</a></li>
            <li><a class="dropdown-item" type="button" href="{{ route('orders.create') }}">Thêm hoá đơn</a></li>
        </ul>
    </div>
@endsection

@section('main')
    <main class="container vh-100 mt-5">
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        <div class="row border border-dark">
            <h3 class="text-center m-3">DANH SÁCH HOÁ ĐƠN BÁN HÀNG</h3>
        </div>
        <div class="row border border-top border-black ">
            
            <table class="table" id="table-order">
                <thead class="text-center">
                    <tr>
                        <th scope="col">Hoá đơn số</th>
                        <th scope="col">Tên khách hàng</th>
                        <th scope="col">Địa chỉ</th>
                        <th scope="col">Điện thoại</th>
                        <th scope="col">Xem</th>
                        <th scope="col">Sửa</th>
                        <th scope="col">Xoá</th>
                    </tr>
                </thead>
                <tbody class="text-center">
                    @foreach ($orders as $order)
                        <tr>
                            <td>{{ $order->ma_hoadon }}</td>
                            <td>{{ $order->ten_kh }}</td>
                            <td>{{ $order->diachi }}</td>
                            <td>{{ $order->dienthoai }}</td>
                            <td><a href="{{route('orders.show', $order->ma_hoadon)}}"><i class="fa-solid fa-eye"></i></a></td>
                            <td><a href="{{route('orders.edit', $order->ma_hoadon)}}"><i class="fa-solid fa-pencil"></i></a>
                            </td>
                            <td>
                                <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal"
                                    data-bs-target="#order{{ $order->ma_hoadon }}"><i class="fa-solid fa-trash"></i>
                                </button>
                                <div class="modal fade" id="order{{ $order->ma_hoadon }}" tabindex="-1"
                                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h1 class="modal-title fs-5" id="exampleModalLabel">Are you sure?</h1>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                Delete order:  {{ $order->ma_hoadon }} ?
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Close</button>
                                                <form action="{{route('orders.destroy', $order->ma_hoadon)}}" method="post">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger">OK</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $orders->links() }}
        </div>
        
    </main>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
@endsection
