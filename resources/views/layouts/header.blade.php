<div class="container-fluid">
    <div class="row">
        <nav class="navbar navbar-expand-lg bg-body-tertiary">
            <div class="container-fluid">
                <a class="navbar-brand" href="#">
                    Adminitrasions
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo02" aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarTogglerDemo02">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        {{-- @yield('page_active') --}}
                        <li class="nav-item">
                            <a class="nav-link" href="">Trang chủ</a>
                        </li>
                        <div class="dropdown">
                            <a class="nav-link active dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Hoá đơn
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" type="button" href="{{route('orders.index')}}"">Danh sách</a></li>
                                <li><a class="dropdown-item" type="button" href="{{route('orders.create')}}">Thêm hoá đơn</a></li>
                            </ul>
                        </div>
                    </ul>
                </div>
            </div>
        </nav>
    </div>
</div>