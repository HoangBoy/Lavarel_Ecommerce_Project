<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    public function index()
    {
        // Lấy giỏ hàng của người dùng hiện tại cùng với sản phẩm liên quan
        $cart = Cart::where('user_id', Auth::id())->with('items.product')->first();

        // Tính tổng tiền hàng
        $total = 0;
        if ($cart) {
            foreach ($cart->items as $item) {
                $total += $item->product->price * $item->quantity; // Giá của sản phẩm nhân với số lượng
            }
        }

        // Trả về view với giỏ hàng và tổng tiền hàng
        return view('checkout', compact('cart', 'total'));
    }

    public function process(Request $request)
    {
        // Xử lý thanh toán
        $request->validate([
            'payment_method' => 'required|string',
            // Thêm các validation khác nếu cần
        ]);

        // Xử lý giỏ hàng
        $cart = Cart::where('user_id', Auth::id())->first();

        if ($cart) {
            // Xoá các mục trong giỏ hàng
            $cart->items()->delete();
            // Xoá giỏ hàng
            $cart->delete();
        }

        // Giả sử thanh toán thành công
        // Thực hiện các hành động như lưu đơn hàng, gửi email, v.v.

        return redirect()->route('checkout.success');
    }

    public function success()
    {
        return view('checkout-success');
    }

    // Giả sử bạn đã có phương thức trong CartController
public function checkout()
{
    $cart = auth()->user()->cart; // Hoặc lấy cart từ database
    $items = $cart->items; // Nếu có quan hệ 'items' trong model Cart

    // Tính tổng tiền
    $totalAmount = $items->sum(function($item) {
        return $item->price * $item->quantity;
    });

    // Truyền tổng tiền tới view
    return view('checkout', compact('cart', 'totalAmount'));
}

}
