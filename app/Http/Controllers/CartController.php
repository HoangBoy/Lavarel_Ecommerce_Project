<?php

namespace App\Http\Controllers;
use App\Models\Product;
use App\Models\Cart;
use App\Models\CartItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class CartController extends Controller
{
  
        // Hiển thị giỏ hàng
        public function index()
        {
            $cart = Cart::where('user_id', Auth::id())->with('items.product')->first();
    
            return view('cart.index', compact('cart'));
        }
    
        // Thêm sản phẩm vào giỏ hàng
        public function add(Request $request, Product $product)
        {
            // Tìm giỏ hàng của người dùng, nếu chưa có thì tạo mới
            $cart = Cart::firstOrCreate(['user_id' => Auth::id()]);
        
            // Kiểm tra xem sản phẩm đã có trong giỏ hàng chưa
            $cartItem = CartItem::where('cart_id', $cart->id)
                                 ->where('product_id', $product->id)
                                 ->first();
        
            if ($cartItem) {
                // Nếu có, kiểm tra số lượng sản phẩm trong kho
                $availableQuantity = $product->quantity; // Lấy số lượng sản phẩm từ bảng products
                if ($availableQuantity > $cartItem->quantity) {
                    // Nếu số lượng trong kho lớn hơn số lượng trong giỏ hàng, tăng số lượng
                    $cartItem->quantity++;
                    $cartItem->save();
                } else {
                    // Nếu số lượng trong kho không đủ, thông báo lỗi hoặc xử lý phù hợp
                    return redirect()->back()->with('error', 'Số lượng sản phẩm không đủ hoặc vượt quá số lượng hiện có trong giỏ hàng.');
                }
            } else {
                // Nếu chưa có, thêm sản phẩm mới vào giỏ hàng
                CartItem::create([
                    'cart_id' => $cart->id,
                    'product_id' => $product->id,
                    'quantity' => 1,
                ]);
            }
        
            return redirect()->route('cart.index')->with('success', 'Sản phẩm đã được thêm vào giỏ hàng.');
        }
        
    
        // Xóa sản phẩm khỏi giỏ hàng
        public function remove(Product $product)
        {
            $cart = Cart::where('user_id', Auth::id())->first();
    
            if ($cart) {
                $cartItem = CartItem::where('cart_id', $cart->id)->where('product_id', $product->id)->first();
    
                if ($cartItem) {
                    $cartItem->delete();
                }
            }
    
            return redirect()->route('cart.index')->with('success', 'Sản phẩm đã được xóa khỏi giỏ hàng.');
        }
    
        public function update(Request $request, Product $product)
        {
            $cart = Cart::where('user_id', Auth::id())->first();
        
            if ($cart) {
                $cartItem = CartItem::where('cart_id', $cart->id)->where('product_id', $product->id)->first();
        
                if ($cartItem) {
    // Lấy số lượng sản phẩm có sẵn từ cơ sở dữ liệu
                    $availableQuantity = $product->quantity;
        
                    if ($request->action === 'increase') {
                        // Tăng số lượng nếu không vượt quá số lượng có sẵn trong kho
                        if ($cartItem->quantity < $availableQuantity) {
                            $cartItem->quantity++;
                        } else {
                            return redirect()->route('cart.index')->with('error', 'Số lượng sản phẩm không đủ.');
                        }
                    } elseif ($request->action === 'decrease' && $cartItem->quantity > 1) {
                        // Giảm số lượng nếu số lượng trong giỏ hàng lớn hơn 1
                        $cartItem->quantity--;
                    }
        
                    $cartItem->save();
                }
            }
        
            return redirect()->route('cart.index')->with('success', 'Cập nhật giỏ hàng thành công.');
        }
        
    }