<?php

namespace App\Http\Controllers;

use App\Http\Resources\CartItem\CartItemCollection;
use App\Model\Cart;
use App\Model\CartItem;
use App\Model\Product;
use App\Model\Order;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CartController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (Auth::guard('api')->check()) {
            $userId = auth('api')->user()->id;
        }

        $cart = Cart::create([
            'key' => md5(uniqid(rand(), true)),
            'userID' => isset($userId) ? $userId : null
        ]);

        return response()->json([
            'message' => 'Cart has been created.',
            'cartToken' => $cart->id,
            'cartKey' => $cart->key
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function show(Cart $cart, Request $request)
    {
        $validator = Validator::make($request->all(), [
            'cartKey' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 400);
        }

        $cartKey = $request->input('cartKey');
        if ($cart->key === $cartKey) {
            return response()->json([
                'cart' => $cart->id,
                'items' => new CartItemCollection($cart->items)
            ]);
        } else {
            return response()->json([
                'message' => 'The cart does not exists.',
            ], 400);
        }
    }

    public function update(Cart $cart, Request $request)
    {
        if (Auth::guard('api')->check()) {
            $userId = auth('api')->user()->id;
            if(!$cart->userID) {
                $cart->userID = $userId;
                $cart->save();
            }
        }
        return response()->json([]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function destroy(Cart $cart, $request)
    {
        $validator = Validator::make($request->all(), [
            'cartKey' => 'required',

        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
            ], 400);
        }

        $cartKey = $request->input('cartKey');

        if ($cart->key === $cartKey) {
            $cart->delete();
            return response()->json(null, 204);
        } else {
            return response()->json([
                'message' => 'The cart does not exists.',
            ], 400);
        }
    }

    public function addProduct(Cart $cart,Request $request)
    {
        $validator = Validator::make($request->all(), [
            'cartKey' => 'required',
            'productID' => 'required',
            'quantity' => 'required|numeric|min:1|max:10',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
            ], 400);
        }

        $cartKey = $request->input('cartKey');
        $productID = $request->input('productID');
        $quantity = $request->input('quantity');

        //Check if the CarKey is Valid
        if ($cart->key == $cartKey) {
            //Check if the proudct exist or return 404 not found.
            try {
                $Product = Product::findOrFail($productID);
            } catch (ModelNotFoundException $e) {
                return response()->json([
                    'message' => 'The Product you\'re trying to add does not exist.',
                ], 404);
            }

            //check if the the same product is already in the Cart, if true update the quantity, if not create a new one.
            $cartItem = CartItem::where(['cart_id' => $cart->getKey(), 'product_id' => $productID])->first();
            if ($cartItem) {
                $cartItem->quantity = $quantity;
                CartItem::where(['cart_id' => $cart->getKey(), 'product_id' => $productID])->update(['quantity' => $quantity]);
            } else {
                CartItem::create(['cart_id' => $cart->getKey(), 'product_id' => $productID, 'quantity' => $quantity]);
            }

            return response()->json(['success'=> true,'message' => 'The Cart was updated with the given product information successfully'], 200);
        } else {

            return response()->json([
                'message' => 'The CarKey you provided does not match the Cart Key for this Cart.',
            ], 400);
        }
    }

    public function checkout(Cart $cart, Request $request)
    {

        if (Auth::guard('api')->check()) {
            $userID = auth('api')->user()->getKey();
        }

        $validator = Validator::make($request->all(), [
            'cartKey' => 'required',
            'name' => 'required',
            'address' => 'required',
           // 'credit card number' => 'required',
           // 'expiration_year' => 'required',
           // 'expiration_month' => 'required',
           // 'cvc' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
            ], 400);
        }

        $cartKey = $request->input('cartKey');
        if ($cart->key == $cartKey) {
            $name = $request->input('name');
            $adress = $request->input('address');
            // $creditCardNumber = $request->input('credit card number');
            $TotalPrice = (float) 0.0;
            $items = $cart->items;

            foreach ($items as $item) {
                $product = Product::find($item->product_id);
                $price = $product->price;
                $TotalPrice = $TotalPrice + ($price * $item->quantity);
            }

            $PaymentGatewayResponse = true;
            $transactionID = md5(uniqid(rand(), true));

            if ($PaymentGatewayResponse) {
                $order = Order::create([
                    'products' => json_encode(new CartItemCollection($items)),
                    'totalPrice' => $TotalPrice,
                    'name' => $name,
                    'address' => $adress,
                    'userID' => isset($userID) ? $userID : null,
                    'transactionID' => $transactionID,
                ]);

                // $cart->delete();

                return response()->json([
                    'success' => true,
                    'message' => 'you\'re order has been completed succefully, thanks for shopping with us! Your order reference ID is '.$order->transactionID,
                    'orderID' => $order->getKey(),
                ], 200);
            }
        } else {
            return response()->json([
                'message' => 'The CarKey you provided does not match the Cart Key for this Cart.',
            ], 400);
        }
    }
}
