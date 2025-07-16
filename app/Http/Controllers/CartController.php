<?php
namespace App\Http\Controllers;
use App\Services\CartService;
use App\Models\Product;
use Illuminate\Http\Request;
class CartController extends Controller
{
    protected $cartService;
    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }
    public function index()
    {
        $cartItems = $this->cartService->get();
        $products = Product::whereIn('id', array_keys($cartItems))->get();
        // Merge product details with cart data
        $cart = [];
        foreach ($cartItems as $productId => $item) {
            $product = $products->find($productId);
            if ($product) {
                $cart[] = [
                    'product' => $product,
                    'quantity' => $item['quantity'],
                    'price' => $item['price'] ?? $product->price,
                    'subtotal' => ($item['price'] ?? $product->price) * $item['quantity']
                ];
            }
        }
        return view('cart.index', [
            'cart' => $cart,
            'total' => $this->cartService->subtotal()
        ]);
    }
    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'integer|min:1'
        ]);
        $product = Product::findOrFail($request->product_id);
        $this->cartService->add(
            $product->id,
            $request->quantity ?? 1,
            $product->price
        );
        return redirect()->back()->with('success', 'Item added to cart!');
    }
    public function update(Request $request, $productId)
    {
        $request->validate([
            'quantity' => 'required|integer|min:0'
        ]);
        $this->cartService->update($productId, $request->quantity);
        return redirect()->back()->with('success', 'Cart updated!');
    }
    public function remove($productId)
    {
        $this->cartService->remove($productId);
        return redirect()->back()->with('success', 'Item removed from cart!');
    }
    public function clear()
    {
        $this->cartService->clear();

        return redirect()->back()->with('success', 'Cart cleared!');
    }
}