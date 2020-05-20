<?php

namespace App\Http\Controllers;

use App\Model\CartItem;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class CartItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\CartItem  $cartItem
     * @return \Illuminate\Http\Response
     */
    public function show(CartItem $cartItem)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\CartItem  $cartItem
     * @return \Illuminate\Http\Response
     */
    public function edit(CartItem $cartItem)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\CartItem  $cartItem
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try{
            $item = CartItem::findOrFail($id);
            if( $request->input('quantity') == 0) {
               $item->delete();
            } else {
              $item->quantity = $request->input('quantity');
              $item->save();
            }
            return response()->json(['success' => true,'message' => 'Cart item Successfully updated!']);

        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => "Cart item not found."
            ], 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\CartItem  $cartItem
     * @return \Illuminate\Http\Response
     */
    public function destroy($cartItem)
    {
        try{
           $item = CartItem::findOrFail($cartItem);
           $item->delete();
           return response()->json(['message' => 'Cart Item Successfully deleted!']);
        }catch (ModelNotFoundException $e) {
                return response()->json([
                    'message' => 'Cart Item not found!',
                ], 404);
        }

    }
}
