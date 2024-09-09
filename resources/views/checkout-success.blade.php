@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Thanh toán thành công!</h2>
    <p>Cảm ơn bạn đã mua sắm tại cửa hàng của chúng tôi. Đơn hàng của bạn đã được xử lý thành công.</p>
    <a href="{{ route('welcome') }}" class="btn btn-primary">Quay về trang chủ</a>
</div>
@endsection
