<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;use App\Models\Size;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
class CartController extends Controller
{
        public function addToCart(Request $request)
        {

            $request->validate([
                'product_id' => 'required|exists:products,id',
                'qty' => 'required|integer|min:1',
            ]);

            $product = $this->getProductDetails($request->product_id);
            $cart = Session::get('cart', []);
            // Check if the product with the same size already exists in the cart
            foreach ($cart as $item) {
                if ($item['product_id'] == $request->product_id ) {
                    return redirect()->back()->with('error', 'This product is already in your cart.');
                }
            }
            // Add the item to the cart
            $cartItemId = count($cart) + 1; // Using a sequential index for cart items
            $cart[$cartItemId] = [
                'product_id' => $product->id,
                'product_name' => $product->name,
                'image' => $product->image,
                'qty' => $request->qty,
                'price' => $request->price,
            ];
            // Save the updated cart back to the session
            Session::put('cart', $cart);
            return redirect()->back()->with('success', 'Product added to cart successfully.');
        }





        //Method to fetch product details based on product id
        private function getProductDetails($productId)
        {
            return Product::findOrFail($productId);
        }
        // Method to fetch size details based on size id
        private function getSizeDetails($sizeId)
        {
            return Size::findOrFail($sizeId);
        }

        // Method to display the cart
        public function showCart()
        {

            $cart = Session::get('cart', []);
            return view('user.pages.cart.cart', compact('cart'));
        }


        public function updateCart(Request $request)
        {
            $cart = Session::get('cart', []);
            $productId = $request->input('product_id');
            $action = $request->input('action'); // 'plus' or 'minus'
            $quantities = $request->input('qty'); // Get the updated quantities
            if (!is_array($quantities)) {
                return response()->json(['error' => 'Invalid input'], 400);
            }
            if (array_key_exists($productId, $cart)) {
                if ($action === 'plus') {
                    $cart[$productId]['qty']++;
                } elseif ($action === 'minus' && $cart[$productId]['qty'] > 1) {
                    $cart[$productId]['qty']--;
                }
            }
            Session::put('cart', $cart);
            // Recalculate subtotal
            $subTotal = 0;
            foreach ($cart as $item) {
                $subTotal += $item['price'] * $item['qty'];
            }
            return redirect()->back()->with('success', 'Cart updated successfully.');
        }



        public function removeItem($productId)
        {
            $cart = Session::get('cart', []);
            if (array_key_exists($productId, $cart)) {
                unset($cart[$productId]);
            }
            Session::put('cart', $cart);
            return redirect()->back()->with('success', 'Product removed from cart successfully.');
        }





       public function checkout(Request $request)
       {
           $cart = Session::get('cart', []);
           $authUser = Auth::user();
           return view('user.pages.checkout.checkout', compact('cart', 'authUser'));
       }

        public function checkoutBulkOrder(Request $request)
        {
            $bulkCart = Session::get('bulkCart', []);
            $authUser = Auth::user();
            return view('user.pages.checkout.checkoutBulk', compact('bulkCart', 'authUser'));
        }

       public function checkoutAsGust(Request $request)
       {
            $cart = Session::get('cart', []);
            return view('user.pages.checkout.checkoutAsGust', compact('cart'));
       }

       public function checkoutAsGustBulk(Request $request)
       {
            $bulkCart = Session::get('bulkCart', []);
            return view('user.pages.checkout.checkoutAsGustBulk', compact('bulkCart'));
       }
}
