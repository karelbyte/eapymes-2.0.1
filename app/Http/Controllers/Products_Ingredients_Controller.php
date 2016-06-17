<?php

namespace App\Http\Controllers;

use App\Models\Product_ingredients;
use App\Models\Products;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class Products_Ingredients_Controller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('ingredients.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function ingredients(Request $request, $id)
    {
        $skip =$request['start'] * $request['take'];
        $products = DB::table('products') ->where('id','<>', $id )
            ->where('mix', 1);
        $filtros = json_decode($request['fillter'], true);
        $order = json_decode($request['order'], true);
        if ( $filtros['name'] !== "" )  $products->where('name', 'LIKE',  "%".$filtros['name']."%");
        if ( $filtros['code'] !== "" )  $products->where('code', 'LIKE',  "%".$filtros['code']."%");
        $products->orderby($order['field'], $order['type'] );
        $total = $products->select('id', 'name', 'code')->count();
        $productlist = $products->skip($skip)->take($request['take'])->get();
        $result = [
            'total' => $total,
            'data' => $productlist,
        ];
        return response()->json($result);
    }


    public function product_ingredients($id)
    {
        $ingreslist = DB::table('product_ingredients')
            ->join('products', 'products.id', '=', 'product_ingredients.idingredient')
            ->select('product_ingredients.idingredient as id','products.code','products.name','product_ingredients.cant')->where('product_ingredients.idproduct',$id)
            ->orderby('products.name','asc')->get();
     //   $product = Products::select('id', 'code', 'name')->where('id', $id)->get();
        $result = [
            'ingreslist' => $ingreslist,
           // 'product' => $product
        ];
        return response()->json($result);
    }


    public function store(Request $request)
    {
        DB::table('product_ingredients')->where('idproduct', '=', $request->input('id'))->delete();
        foreach ($request->input('values') as $ingres) {
            Product_ingredients::create([
                    'idproduct' => $request->input('id'),
                    'idingredient' => $ingres['id'],
                    'cant' => $ingres['cant']]
            );
        };
        $data = [
            'codigo' => 200,
            'msj' => "Ingredientes guardados."
        ];
        return response()->json($data);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
