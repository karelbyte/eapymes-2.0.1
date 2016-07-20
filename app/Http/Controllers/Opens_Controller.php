<?php

namespace App\Http\Controllers;

use App\Models\Inventorys;
use App\Models\Shelves;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class Opens_Controller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       return view('opens.index');
    }

    public function getstores()
    {
        $storehouseslist = DB::table('stores')->where('state', 0)->get();
        $result = [
            'data' =>  $storehouseslist
        ];
        return response()->json($result);
    }

    public function lists(Request $request, $id)
    {
        $skip =$request['start'] * $request['take'];
        $inventory = DB::table('inventorys')
            ->join('products', 'products.id', '=','inventorys.idproduct')
            ->join('shelves', 'shelves.id', '=','inventorys.idshelve')
            ->where('inventorys.idstore', $id);
        $filtros = json_decode($request['fillter'], true);
        $order = json_decode($request['order'], true);
        if ( $filtros['name'] !== "" )  $inventory->where('products.name', 'LIKE',  "%".$filtros['name']."%");
        if ( $filtros['code'] !== "" )  $inventory->where('products.code', 'LIKE',  "%".$filtros['code']."%");
        $inventory->orderby($order['field'], $order['type'] );
        $total = $inventory->select('inventorys.id', 'products.name', 'products.code', 'shelves.name as shelve', 'cant')->count();
        $inventorylist = $inventory->skip($skip)->take($request['take'])->get();
        $shelves = DB::table('shelves')->select('id', 'name')->where('idstore', $id)->get();
        $result = [
            'total' => $total,
            'data' => $inventorylist,
            'shelves' => $shelves,
        ];
        return response()->json($result);
    }

    public function products(Request $request, $id)
    {

       $products = DB::table('products')
           ->whereNotExists(function ($query) {
               $query->select(DB::raw('idproduct'))
                   ->from('inventorys')
                   ->whereRaw('products.id = inventorys.idproduct');

           })
           ->where('products.active', '=',  1);

       $skip =$request['start'] * $request['take'];
       $filtros = json_decode($request['fillter'], true);
       $order = json_decode($request['order'], true);
       if ( $filtros['name'] !== "" )  $products->where('products.name', 'LIKE',  "%".$filtros['name']."%");
       if ( $filtros['code'] !== "" )  $products->where('products.code', 'LIKE',  "%".$filtros['code']."%");
       $products->orderby($order['field'], $order['type'] );
       $total = $products->select('products.id', 'products.name', 'products.code')->count();
       $productlist = $products->skip($skip)->take($request['take'])->get();
       $shelves = DB::table('shelves')->select('id', 'name')->where('idstore', $id)->distinct()->get();
       $result = [
           'total' => $total,
           'data' => $productlist,
           'shelves' => $shelves,
       ];
       return response()->json($result);
    }

    public function store(Request $request)
    {
        $inventory = new Inventorys();
        $inventory->idstore = $request->input('idstore');
        $inventory->idproduct = $request->input('id');
        $inventory->idshelve = $request->input('idshelve');
        $inventory->cant = $request->input('cant');
        $inventory->sentinel = 0;
        $inventory->save();
        $data = [
            'codigo' => 200,
            'msj' => "Producto añadido correctamente."
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
