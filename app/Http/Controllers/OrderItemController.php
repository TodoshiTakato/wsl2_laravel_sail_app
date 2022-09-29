<?php

namespace App\Http\Controllers;

use App\OrderItem;
use Illuminate\Http\Request;

class OrderItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()                                       //  '/order-items' GET route_name = 'user.order-items.index'
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()                                      //  '/order-items/create' GET route_name = 'user.order-items.create'
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)                      //  '/order-items' POST route_name = 'user.order-items.store'
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\OrderItem  $orderItem
     * @return \Illuminate\Http\Response
     */
    public function show(OrderItem $orderItem)                  //  '/order-items/{order}' GET route_name = 'user.order-items.show'
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\OrderItem  $orderItem
     * @return \Illuminate\Http\Response
     */
    public function edit(OrderItem $orderItem)                  //  '/order-items/{order}/edit' GET route_name = 'user.order-items.edit'
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\OrderItem  $orderItem
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, OrderItem $orderItem)  //  '/order-items/{order}' PUT/PATCH route_name = 'user.order-items.update'
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\OrderItem  $orderItem
     * @return \Illuminate\Http\Response
     */
    public function destroy(OrderItem $orderItem)                //  '/order-items/{order}' DELETE route_name = 'user.order-items.destroy'
    {
        //
    }
}
