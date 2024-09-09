<!DOCTYPE html>
<html>
<head>
    <title>Checkout</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4">Hoàn Tất Thanh Toán</h1>

        <h2 class="mb-3">Giỏ hàng</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Tên sản phẩm</th>
                    <th>Số lượng</th>
                    <th>Đơn giá</th>
                    <th>Thành tiền</th>
                </tr>
            </thead>
            <tbody>
                @foreach($cart->items as $item)
                    <tr>
                        <td>{{ $item->product->name }}</td>
                        <td>{{ $item->product->quantity }}</td>
                        <td>{{ number_format($item->product->price, 2) }} VNĐ</td>
                        <td>{{ number_format($item->product->price * $item->product->quantity, 2) }} VNĐ</td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="3" class="text-right">Tổng cộng</td>
                    <td>{{ number_format($total, 2) }} VNĐ</td>
                </tr>
            </tfoot>
        </table>

        <h2 class="mb-3">Chọn phương thức thanh toán</h2>
        <form action="{{ route('checkout.success') }}" method="post">
            @csrf
            <div class="form-check">
                <input class="form-check-input" type="radio" name="payment_method" id="credit_card" value="credit_card" checked>
                <label class="form-check-label" for="credit_card">
                    Thẻ tín dụng
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="payment_method" id="paypal" value="paypal">
                <label class="form-check-label" for="paypal">
                    PayPal
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="payment_method" id="bank_transfer" value="bank_transfer">
                <label class="form-check-label" for="bank_transfer">
                    Chuyển khoản ngân hàng
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="payment_method" id="bank_transfer" value="bank_transfer">
                <label class="form-check-label" for="bank_transfer">
                    Thanh toán khi nhận hàng
                </label>
            </div>
            <button type="submit" class="btn btn-primary mt-3">Xác nhận thanh toán</button>
        </form>
    </div>

    <!-- Bootstrap JS, Popper.js, and jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
