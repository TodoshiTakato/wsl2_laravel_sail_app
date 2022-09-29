<?php

namespace App\Http\Controllers;

use App\Order;
use App\OrderItem;
use App\Product;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;


class ShopController extends Controller {

    public function getOrder($withCount=null)
    {
        $user = Auth::user();
        if (isset($withCount)) {
//            dump(Order::withCount($withCount)->firstOrCreate(['user_id' => $user->id, 'paid' => 0])->lockForUpdate()->first());
//            dump(Order::withCount($withCount)->firstOrCreate(['user_id' => $user->id, 'paid' => 0])->lockForUpdate()->first()->order_items_count);
            return Order::withCount($withCount)->firstOrCreate(['user_id' => $user->id, 'paid' => 0]);
        }
        return Order::firstOrCreate(['user_id' => $user->id, 'paid' => 0]);
    }

    public function getOrderItem(Product $product, $order=null, $withCount=null)
    {
        if(!isset($order)) {
            if (!isset($withCount)) {
                $order = $this->getOrder();
            } else {
                $order = $this->getOrder($withCount);
            }
        }
        return OrderItem::firstOrCreate(['order_id' => $order->id,'product_id' => $product->id]);
    }

    public function getCartData($delete=null)
    {
        $cookie_data = stripslashes(Cookie::get("shopping_cart"));
        if (isset($delete)) {
            Cookie::queue(Cookie::forget("shopping_cart")); // Delete the cookie, because we are already authenticated
        }
        return json_decode($cookie_data, true);
    }

    public function getOrderData($order)
    {
//        dd($order->order_items_count);
        if ($order->order_items_count != 0) {
            $cart_data = [];
            foreach ($order->order_items as $key => $values) {
                $cart_data[$values->product_id] = [
                    "product_id" => $values->product_id,
                    "product_name" => $values->product->name,
                    "product_price" => $values->product->price,
                    "item_quantity" => $values->quantity,
                    "item_price" => $values->item_price,
                ];
            }
            $cart_data["total"] = $order->total_price;
            return $cart_data;
        } else {
            dd("Error in getOrderData $ order->order_items_count is null or something");
        }
    }

    public function setCartData($cart_data)
    {
        $item_data = json_encode($cart_data);
        $minutes = 525960;
        Cookie::queue(Cookie::make("shopping_cart", $item_data, $minutes));
    }

    public function setOrderData()
    {
        $cart_data = $this->getCartData(true); // Get Cart/Order data from Cookie and DELETE the cookie
        $order = $this->getOrder();
        if (is_array($cart_data)) {
            unset($cart_data["total"]); // delete the "total" field from item list array
            try {
                DB::transaction(function () use ($order, $cart_data) {
                    $order->total_price = 0;
                    foreach ($cart_data as $key => $value) {
                        $product = Product::find($key);
                        $order_item = $this->getOrderItem($product, $order);
                        $order_item->update(["quantity" => $value["item_quantity"], "item_price" => $value["item_quantity"]]);
                        $order->increment("total_price", $order_item->item_price);
                    }
                });
            } catch (\Exception $e) {
                dd("General Exception: ".$e->getMessage());
            } catch (\Error $e) {
                dd("General Error: ".$e->getMessage());
            }
        }
    }

    public function index()
    {
        if (Auth::check()) {
            $order = $this->setOrderData();
        }
        return view("shop.index");
    }

    public function products()
    {
        $products = Product::paginate(6);
        $class_array = array(
            "des",
            "dev",
            "gra",
        );
        $images_array = array(
            "../assets/images/products/product_01.jpg",
            "../assets/images/products/product_02.jpg",
            "../assets/images/products/product_03.jpg",
            "../assets/images/products/product_04.jpg",
            "../assets/images/products/product_05.jpg",
            "../assets/images/products/product_06.jpg",
            "../assets/images/products/product_07.jpg",
            "../assets/images/products/product_08.jpg",
            "../assets/images/products/product_09.jpg",
            "../assets/images/products/product_10.jpg",
            "../assets/images/products/product_11.jpg",
            "../assets/images/products/product_12.jpg",
            "../assets/images/products/product_13.jpg",
            "../assets/images/products/product_14.jpg",
            "../assets/images/products/product_15.jpg",
            "../assets/images/products/product_16.jpg",
        );

        if(Auth::check()) {
            if (Cookie::has("shopping_cart")) {
                $this->setOrderData();
            }
            $order = $this->getOrder();
            $cart_data = [];
            foreach ($order->order_items as $key => $values) {
                $cart_data[$values->product_id] = [
                    "item_quantity" => $values->quantity,
                ];
            }
            $prod_id_list = array_keys($cart_data);
            return view("shop.products", compact(
                "products",
                "images_array",
                "class_array",
                "cart_data",
                "prod_id_list"
            ));
        } elseif (Cookie::has("shopping_cart")) {
            $cart_data = $this->getCartData();
            $prod_id_list = array_keys($cart_data);

            return view("shop.products", compact(
                "products",
                "images_array",
                "class_array",
                "cart_data",
                "prod_id_list"
            ));
        } else {
            return view("shop.products", compact(
                "products",
                "images_array",
                "class_array"
            ));
        }
    }

    public function addToCart(Product $product)
    {
        if (Auth::check()) {
            $order_item = $this->getOrderItem($product);
            try {
                DB::transaction(function () use ($order_item) {
                    $order_item->lockForUpdate()->increment("quantity");
                    $order_item->update(['item_price' => $order_item->quantity]);
//                    $order_item->setItemPriceAttribute($order_item->quantity);
                    $order_item->order->lockForUpdate()->increment("total_price", $order_item->item_price);
                });
            } catch (\Exception $e) {
                dd("General Exception: ".$e->getMessage());
            } catch (\Error $e) {
                dd("General Error: ".$e->getMessage());
            }

            return response()->json([
                "status" => '"'.$product->name.'" Added to Cart',
                "item_quantity" => $order_item->quantity,
            ]);
        } else {
            $prod_id = intval($product->id);
            $prod_name = $product->name;
            $priceval = intval($product->price);

            if (Cookie::has("shopping_cart")) {
                $cart_data = $this->getCartData();
            } else {
                $cart_data = array();
            }

            $prod_id_list = array_keys($cart_data);
            if (in_array($prod_id, $prod_id_list)) {
                foreach ($cart_data as $key => $value) {
                    $cart_data[$prod_id]["item_quantity"] += 1;
                    $old_priceval = $cart_data[$prod_id]["item_price"];
                    $cart_data[$prod_id]["item_price"] = ($old_priceval + $priceval);
                    $cart_data["total"] += $priceval;
                    $this->setCartData($cart_data);
                    return response()->json([
                        "status" => '"' . $cart_data[$prod_id]["product_name"] . '" Already Added to Cart + Quantity was Updated',
                        "item_quantity" => $cart_data[$prod_id]["item_quantity"],
                    ]);
                }
            } else {
                if ($product) {
                    $item_array = array(
                        "product_id" => $prod_id,
                        "product_name" => $prod_name,
                        "product_price" => $priceval,
                        "item_quantity" => 1,
                        "item_price" => $priceval,
//                    'item_image' => $prod_image
                    );
                    $cart_data[$prod_id] = $item_array;
                    if (isset($cart_data['total'])) {
                        $cart_data["total"] += $item_array["item_price"];
                    } else {
                        $cart_data["total"] = 0;
                        $cart_data["total"] += $item_array["item_price"];
                    }

                    $this->setCartData($cart_data);
                    return response()->json([
                        "status" => '"' . $prod_name . '" Added to Cart',
                        "item_quantity" => intval($item_array["item_quantity"]),
                    ]);
                }
            }
        }
    }

    public function subtractOneFromCart(Product $product)
    {
        if (Auth::check()) {

            $order_item = $this->getOrderItem($product, null, "order_items");

            if ($order_item->quantity > 1) {
                try {
                    DB::transaction(function () use ($order_item) {
                        $order_item->decrement("quantity");
                        $order_item->update(['item_price' => $order_item->quantity]);
                        $order_item->order->decrement("total_price", $order_item->item_price);
                    });
                } catch (\Exception $e) {
                    dd("General Exception: ".$e->getMessage());
                } catch (\Error $e) {
                    dd("General Error: ".$e->getMessage());
                }

                return response()->json([
                    "status" => 'One "'.$product->name.'" was subtracted from your cart',
                    "item_quantity" => intval($order_item->quantity),
                    "delete" => 0,
                ]);
            } elseif ($order_item->quantity == 1) {
                try {
                    DB::transaction(function () use ($order_item) {
                        $item_price = $order_item->item_price;
                        $order_item->delete();
                        if ($order_item->order->order_items_count == 0){
                            $order_item->order->delete();
                        } else {
                            $order_item->order->decrement("total_price", $item_price);
                        }
                    });
                } catch (\Exception $e) {
                    dd("General Exception: ".$e->getMessage());
                } catch (\Error $e) {
                    dd("General Error: ".$e->getMessage());
                }

                return response()->json([
                    "status" => $product->name." was Removed from your Cart",
                    "delete" => 1,
                ]);
            }
        } else {
            $prod_id = intval($product->id);
            $priceval = intval($product->price);
            if (Cookie::has("shopping_cart")) {
                $cart_data = $this->getCartData();
                $prod_id_list = array_keys($cart_data);
                if (in_array($prod_id, $prod_id_list)) {
                    if ($cart_data[$prod_id]["item_quantity"] > 1) {
                        $cart_data[$prod_id]["item_quantity"] -= 1;
                        $old_priceval = $cart_data[$prod_id]["item_price"];
                        $cart_data[$prod_id]["item_price"] = ($old_priceval - $priceval);
                        $cart_data["total"] -= $priceval;
                        $this->setCartData($cart_data);
                        return response()->json([
                            "status" => 'One "' . $cart_data[$prod_id]["product_name"] . '" was subtracted from your cart',
                            "item_quantity" => intval($cart_data[$prod_id]["item_quantity"]),
                            "delete" => 0,
                        ]);
                    } else {
                        $product_name = $cart_data[$prod_id]["product_name"];
                        $cart_data["total"] -= $priceval;
                        unset($cart_data[$prod_id]);
                        $this->setCartData($cart_data);
                        return response()->json([
                            "status" => $product_name . " was Removed from your Cart",
                            "delete" => 1,
                        ]);
                    }
                }
            }
        }
    }

    public function removeFromCart(Product $product)
    {
        if (Auth::check()) {
            $order_item = $this->getOrderItem($product);
            try {
                DB::transaction(function () use ($order_item) {
                    $order_item->order->decrement("total_price", $order_item->item_price);
                    $order_item->delete();
                });
            } catch (\Exception $e) {
                dd("General Exception: ".$e->getMessage());
            } catch (\Error $e) {
                dd("General Error: ".$e->getMessage());
            }

            return response()->json([
                "status"=> $product->name." was Removed from your Cart",
                "total" => number_format(($order_item->order->total_price/100), 2, ",", " ") . " UZS",
            ]);
        } else {
            $prod_id = intval($product->id);
            $priceval = intval($product->price);

            $cookie_data = stripslashes(Cookie::get("shopping_cart"));
            $cart_data = json_decode($cookie_data, true);

            $prod_id_list = array_keys($cart_data);

            if(in_array($prod_id, $prod_id_list)) {
                $product_name = $cart_data[$prod_id]["product_name"];
                $cart_data["total"] -= $cart_data[$prod_id]["item_price"];
                unset($cart_data[$prod_id]);
                $this->setCartData($cart_data);
                return response()->json([
                    "status"=> $product_name." was Removed from your Cart",
                    "total" => number_format((($cart_data["total"])/100), 2, ",", " ") . " UZS",
                ]);
            }
        }
    }

    public function cart()
    {
        if (Auth::check()) {
            if (Cookie::has("shopping_cart")) {
                $this->setOrderData();
            }
            $order = $this->getOrder("order_items");
            $cart_data = $this->getOrderData($order);
            return view('shop.cart', compact('cart_data'));
        } elseif (Cookie::has("shopping_cart")) {
            Session::put("url.intended", request()->fullUrl());
            $cart_data = $this->getCartData();
            return view("shop.cart", compact("cart_data"));
        }
    }

    public function getCart(Request $request, Product $product){
        $cart_data = $this->getCartData();
        return $cart_data;
    }

    public function cartUpdateQuantity(Request $request, Product $product)
    {
        if (Auth::check()) {
            if (Cookie::has("shopping_cart")) {
                $this->setOrderData();
            }
            $order_item = $this->getOrderItem($product);
            try {
                DB::transaction(function () use ($request, $product, $order_item) {
                    $order_item->order->decrement("total_price", $order_item->item_price);
                    $order_item->update([
                        "quantity"=> $request->quantity,
                        "item_price"=> $request->quantity
                    ]);
                    $order_item->order->increment("total_price", $order_item->item_price);
                });
            } catch (\Exception $e) {
                dd("General Exception: ".$e->getMessage());
            } catch (\Error $e) {
                dd("General Error: ".$e->getMessage());
            }

            return response()->json([
                "status" => $order_item->quantity.' "'.$product->name.'"(s) are in the cart',
                "item_price" => number_format(($order_item->item_price/100), 2, ",", " ") . " UZS",
                "total" => number_format(($order_item->order->total_price/100), 2, ",", " ") . " UZS",
            ]);
        } elseif (Cookie::has("shopping_cart")) {
            $cart_data = $this->getCartData();
            $prod_id = $product->id;
            $priceval = intval($product->price);
            $quantity = intval($request->quantity);
            $prod_id_list = array_keys($cart_data);

            if (in_array($prod_id, $prod_id_list) && isset($cart_data[$prod_id])) {
                $cart_data["total"] -= $cart_data[$prod_id]["item_price"];
                $cart_data[$prod_id]["item_quantity"] = $quantity;
                $cart_data[$prod_id]["item_price"] = ($quantity * $priceval);
                $cart_data["total"] += $cart_data[$prod_id]["item_price"];
                $this->setCartData($cart_data);
            }
            return response()->json([
                "status" => $quantity . ' "' . $cart_data[$prod_id]["product_name"] . '"(s) are in the cart',
                "item_price" => number_format((($cart_data[$prod_id]["item_price"])/100), 2, ",", " ") . " UZS",
                "total" => number_format((($cart_data["total"])/100), 2, ",", " ") . " UZS",
            ]);
        }
    }

    public function cartLoadData()
    {
        if (Auth::check()) {
            if (Cookie::has("shopping_cart")) {
                $this->setOrderData();
            }
            $order = $this->getOrder("order_items");
            if ($order->order_items_count != 0) {
                $totalcart = $order->order_items_count;
            } else {
                $totalcart = 0;
            }
            return response()->json(array("totalcart" => $totalcart));
        } elseif ( Cookie::get("shopping_cart") ) {
            $cookie_data = stripslashes(Cookie::get("shopping_cart"));
            $cart_data = json_decode($cookie_data, true);
            $totalcart = count($cart_data)-1; // Removing the "total" cart/order price field
            return response()->json(array("totalcart" => $totalcart));
        } else {
            $totalcart = "0";
            return response()->json(array("totalcart" => $totalcart));
        }
    }

    public function cartClear()
    {
        if (Auth::check()) {
            try {
                DB::transaction(function () {
                    $this->getOrder()->delete();
                });
            } catch (\Exception $e) {
                dd("General Exception: ".$e->getMessage());
            } catch (\Error $e) {
                dd("General Error: ".$e->getMessage());
            }
            return response()->json(["status" => "Your Cart was Cleared"]);
        } else {
            Cookie::queue(Cookie::forget("shopping_cart"));
            return response()->json(["status" => "Your Cart was Cleared"]);
        }
    }

    public function about()
    {
        if (Auth::check()) {
            if (Cookie::has("shopping_cart")) {
                $this->setOrderData();
            }
        }
        return view("shop.about");
    }

    public function contact()
    {
        if (Auth::check()) {
            if (Cookie::has("shopping_cart")) {
                $this->setOrderData();
            }
        }
        return view("shop.contact");
    }
}
