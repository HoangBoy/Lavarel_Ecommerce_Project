<!-- views/products/show.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container my-5">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card">
                <div class="card-body">
                    <h1 class="card-title">{{ $product->name }}</h1>
                    <p class="card-text">{{ $product->description }}</p>
                    <p><strong>Số lượng:</strong> {{ $product->quantity }}</p>
                    <p><strong>Giá:</strong> {{ number_format($product->price, 0, ',', '.') }} VND</p>
                    <p><strong>Danh mục:</strong> {{ $product->category->name }}</p>

                    @auth
                        <!-- Form để thêm sản phẩm vào giỏ hàng -->
                        <form action="{{ route('cart.add', $product->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-primary mt-3">Thêm vào giỏ hàng</button>
                        </form>
                    @else
                        <p class="mt-3">Vui lòng <a href="{{ route('login') }}">đăng nhập</a> để thêm sản phẩm vào giỏ hàng.</p>
                    @endauth
                </div>
            </div>
            <div class="mt-4">
                <a href="{{ route('welcome') }}" class="btn btn-secondary">Quay lại danh sách</a>
            </div>
        </div>
    </div>
</div>
@endsection
