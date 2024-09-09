<!-- views/cart/index.blade.php -->
    @extends('layouts.app')
@section('content')
<h1>Giỏ hàng của bạn</h1>

@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif
@if(session('error'))
    <div class="alert alert-success">
        {{ session('error') }}
    </div>
@endif

@if($cart && $cart->items->count() > 0)
    <table class="table">
        <thead>
            <tr>
                <th>Tên sản phẩm</th>
                <th>Số lượng</th>
                <th>Giá</th>
                <th>Danh mục</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            @foreach($cart->items as $item)
                <tr>
                    <td>{{ $item->product->name }}</td>
                    <td>
                        <!-- Form để giảm số lượng -->
                        <form action="{{ route('cart.update', $item->product->id) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="action" value="decrease">
                            <button type="submit" class="btn btn-warning">-</button>
                        </form>
                        {{ $item->quantity }}
                        <!-- Form để tăng số lượng -->
                        <form action="{{ route('cart.update', $item->product->id) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="action" value="increase">
                            <button type="submit" class="btn btn-success">+</button>
                        </form>
                    </td>
                    <td>{{ $item->product->price }}</td>
                    <td>{{ $item->product->category->name }}</td>
                    <td>
                        <form action="{{ route('cart.remove', $item->product->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Xoá</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@else
    <p>Giỏ hàng của bạn trống.</p>
@endif
  <a href="{{ route('checkout') }}" class="btn btn-success">Tiến hành thanh toán</a>
<a href="{{ route('welcome') }}" class="btn btn-primary">Tiếp tục mua sắm</a>
@endsection