<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\DB;
use App\Category;
use App\Product;

class CategoriesController0001 extends Controller
{
    public function index_page () {
//        $categories = DB::table('Categories')->get();
//        $products = DB::table('Products')->get();
        $categories = Category::all();
        $products = Product::all();
        $User_Dropdown = Auth::user();
        return view('welcome', compact('categories','products', 'User_Dropdown'));
    }
    public function Categories() {
     // $categories = DB::table('Categories')->get();       //Аналог. Alternative того что снизу
        $categories = Category::all();                  //передаём все категории
        return view('categories.categories', compact('categories'));
    }
    public function Category ($id) {
     // $category = DB::table('Categories')->find($id);       //Аналог. Alternative того что снизу
        $category = Category::find($id);                  //передаём определённую категорию по id
        $categories = Category::all();                    //передаём все категории
        return view('categories.category', compact('category'), compact('categories'));
    }








    //                      #RETRIEVING RESULTS
    //
    //  Retrieving All Rows From A Table
    //  $users = DB::table('users')->get();
    //
    //  Retrieving A Single Row / Column From A Table
    //  $user = DB::table('users')->where('name', 'John')->first();
    //
    //  Retrieving A Single Value From A Record
    //  $email = DB::table('users')->where('name', 'John')->value('email');
    //
    //  To retrieve a single row by its id column value
    //  $user = DB::table('users')->find(3);
    //
    //  Retrieving A List Of Column Values
    //  to retrieve a Collection containing the values of a single column
    //  $titles = DB::table('roles')->pluck('title');
    //
    //  You may also specify a custom key column for the returned Collection
    //  $roles = DB::table('roles')->pluck('title', 'name');


    //                      #CHUNKING RESULTS
    //  If you need to work with thousands of database records, consider using the chunk method.
    //  This method retrieves a small chunk of the results at a time and feeds each chunk into a Closure for processing.
    //  This method is very useful for writing Artisan commands that process thousands of records.
    //  For example, let's work with the entire users table in chunks of 100 records at a time:
    //
    //  DB::table('users')->orderBy('id')->chunk(100, function ($users) {
    //      foreach ($users as $user) {
    //          // Process the records HERE...
    //      }
    //  });
    //
    //  You may stop further chunks from being processed by returning false from the Closure:
    //  DB::table('users')->orderBy('id')->chunk(100, function ($users) {
    //      // Process the records HERE...
    //      return false;
    //  });

    //  If you are updating database records while chunking results, your chunk results could change in unexpected ways.
    //  So, when updating records while chunking, it is always best to use the chunkById method instead.
    //  This method will automatically paginate the results based on the record's primary key:
    //  DB::table('users')->where('active', false)
    //      ->chunkById(100, function ($users) {
    //          foreach ($users as $user) {
    //              DB::table('users')
    //                  ->where('id', $user->id)
    //                  ->update(['active' => true]);
    //          }
    //      });
                 //   !!!  #WARNING  !!!
                 //  WHEN UPDATING OR DELETING RECORDS INSIDE THE CHUNK CALLBACK, ANY CHANGES TO THE PRIMARY KEY
                 //  OR FOREIGN KEYS COULD AFFECT THE CHUNK QUERY. THIS COULD POTENTIALLY RESULT IN RECORDS NOT BEING
                 //  INCLUDED IN THE CHUNKED RESULTS.


    //                    #AGGREGATES
    //  The query builder also provides a variety of aggregate methods such as count, max, min, avg, and sum.
    //  You may call any of these methods after constructing your query:
    //  $users = DB::table('users')->count();
    //
    //  $price = DB::table('orders')->max('price');

    //  You may combine these methods with other clauses:
    //  $price = DB::table('orders')
    //               ->where('finalized', 1)
    //               ->avg('price');

    //  Determining If Records Exist
    //  Instead of using the count method to determine if any records exist that match your query's constraints,
    //  you may use the exists and doesntExist methods:
    //  return DB::table('orders')->where('finalized', 1)->exists();
    //
    //  return DB::table('orders')->where('finalized', 1)->doesntExist();


    //                    #SELECTS
    //  Specifying A Select Clause
    //  You may not always want to select all columns from a database table.
    //  Using the select method, you can specify a custom select clause for the query:
    //  $users = DB::table('users')->select('name', 'email as user_email')->get();

    //  The distinct method allows you to force the query to return distinct results:
    //  $users = DB::table('users')->distinct()->get();

    //  If you already have a query builder instance and you wish to add a column to its existing select clause,
    //  you may use the addSelect method:
    //  $query = DB::table('users')->select('name');
    //
    //  $users = $query->addSelect('age')->get();

    //                    #RAW EXPRESSIONS
    //  Sometimes you may need to use a raw expression in a query.
    //  To create a raw expression, you may use the DB::raw method:
    //
    //  $users = DB::table('users')
    //                     ->select(DB::raw('count(*) as user_count, status'))
    //                     ->where('status', '<>', 1)
    //                     ->groupBy('status')
    //                     ->get();

                        //   !!!  #WARNING  !!!
                        //  Raw statements will be injected into the query as strings,
                        //  so you should be extremely careful to not create SQL injection vulnerabilities.


    //                    #RAW METHODS
    //  Instead of using DB::raw,you may also use the following methods to insert a raw expression
    //  into various parts of your query.

    //  selectRaw
    //  The selectRaw method can be used in place of addSelect(DB::raw(...)).
    //  This method accepts an optional array of bindings as its second argument:
    //  $orders = DB::table('orders')
    //                ->selectRaw('price * ? as price_with_tax', [1.0825])
    //                ->get();

    //  whereRaw / orWhereRaw
    //  The whereRaw and orWhereRaw methods can be used to inject a raw where clause into your query.
    //  These methods accept an optional array of bindings as their second argument:
    //  $orders = DB::table('orders')
    //                ->whereRaw('price > IF(state = "TX", ?, 100)', [200])
    //                ->get();

    //  havingRaw / orHavingRaw
    //  The havingRaw and orHavingRaw methods may be used to set a raw string as the value of the having clause.
    //  These methods accept an optional array of bindings as their second argument:
    //  $orders = DB::table('orders')
    //                ->select('department', DB::raw('SUM(price) as total_sales'))
    //                ->groupBy('department')
    //                ->havingRaw('SUM(price) > ?', [2500])
    //                ->get();

    //  orderByRaw
    //  The orderByRaw method may be used to set a raw string as the value of the order by clause:
    //  $orders = DB::table('orders')
    //                ->orderByRaw('updated_at - created_at DESC')
    //                ->get();

    //  groupByRaw
    //  The groupByRaw method may be used to set a raw string as the value of the group by clause:
    //  $orders = DB::table('orders')
    //                ->select('city', 'state')
    //                ->groupByRaw('city, state')
    //                ->get();


    //                    #JOINS
    //  Inner Join Clause
    //  The query builder may also be used to write join statements. To perform a basic "inner join",
    //  you may use the join method on a query builder instance. The first argument passed to the join method is
    //  the name of the table you need to join to, while the remaining arguments specify the column constraints
    //  for the join. You can even join to multiple tables in a single query:
    //  $users = DB::table('users')
    //            ->join('contacts', 'users.id', '=', 'contacts.user_id')
    //            ->join('orders', 'users.id', '=', 'orders.user_id')
    //            ->select('users.*', 'contacts.phone', 'orders.price')
    //            ->get();











}
