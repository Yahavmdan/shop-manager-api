<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $response = Product::all();
        return response($response,200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'          => 'required|string',
            'price'         => 'required|numeric',
            'description'   => 'required|string',
        ]);
        return Product::create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Product::find($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name'          => 'required|string',
            'price'         => 'required|numeric',
            'description'   => 'required|string',
        ]);

        $product = Product::find($id);
        $product->update($request->all());

        return $product;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return Product::destroy($id);
    }

    /**
     * Search for a name.
     *
     * @param  str  $name
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function search($searchValue)
    {
        if ($searchValue == 0) {
            return Product::all();
        }
        return Product::
        where('name', 'like', '%' . $searchValue . '%')
            ->orWhere('price', 'like', '%' . $searchValue . '%')
            ->orWhere('description', 'like', '%' . $searchValue . '%')
            ->get();
    }

//    public function sort(Request $request)
//    {
//        return Product::orderBy('price', 'DESC')->get();
//        return Product::orderBy('price', 'ASC')->get();
//        return Product::orderBy('created_at', 'DESC')->get();
//        return Product::orderBy('created_at', 'ASC')->get();
//        return Product::orderBy('updated_at', 'DESC')->get();
//        return Product::orderBy('updated_at', 'ASC')->get();
//    }
}
