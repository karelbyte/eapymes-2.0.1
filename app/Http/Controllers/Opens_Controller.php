<?php

namespace App\Http\Controllers;

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

    public function lists(Request $request)
    {
        $skip =$request['start'] * $request['take'];
        $storehouses = DB::table('stores')
            ->join('store_types', 'stores.idtype', '=', 'store_types.id')
            ->join('product_state', 'stores.state', '=', 'product_state.id');
        $filtros = json_decode($request['fillter'], true);
        $order = json_decode($request['order'], true);
        if ( $filtros['name'] !== "" ) $storehouses->where('stores.name', 'LIKE',  "%".$filtros['name']."%");
        $storehouses->orderby($order['field'], $order['type'] );
        $total =  $storehouses->select('stores.id', 'stores.name', 'store_types.name as type', 'product_state.state as state')->count();
        $storehouseslist =  $storehouses->skip($skip)->take($request['take'])->get();
        $storetype = DB::table('store_types')->select('*')->get();
        $result = [
            'total' => $total,
            'data' =>  $storehouseslist,
            'storetype' => $storetype
        ];
        return response()->json($result);
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
