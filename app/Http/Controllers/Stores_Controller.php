<?php

namespace App\Http\Controllers;

use App\Models\Stores;
use App\Models\Userhelp;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class Stores_Controller extends Controller
{
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


    public function index()
    {
        return view('stores.index');
    }


    public function store(Requests\Stores_Request $request)
    {
        $store = new Stores();
        $store->name = $request->input('name');
        $store->idtype = $request->input('idtype');
        $store->state = 0;
        $store->save();
        $data = [
            'codigo' => 'ok',
            'msj' => "Almacen creado correctamente."
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
        $store = Stores::select('id', 'name', 'idtype', 'state')->where('id', $id)->get();
        return response()->json($store[0]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {  }


    public function update(Requests\Stores_Update_Request $request, $id)
    {
        if ($request['name'] == "closeQ..") {
            // transferencia hacia stock
            DB::statement('call close_opens_store('.$id.')');
            //----------------------
            $store = Stores::find($id);
            $store->state = 2;
            $store->save();

            $data = [
                'codigo' => 'ok',
                'msj' => "Almacen cerrado correctamente."
            ];
        } else {
            if ( is_null(DB::table('stores')->where('name',  $request['name'])->where('id', '<>', $id)->first())){
                $store = Stores::find($id);
                $store->name = $request->input('name');
                $store->idtype = $request->input('idtype');
                $store->save();
                $data = [
                    'codigo' => 200,
                    'msj' => "Datos actualizados correctamente."
                ];
            }
            else {
                $data = [
                    'codigo' => 500,
                    'msj' => "El almacen ya existe."
                ];
            }
        }

        return response()->json($data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $store = Stores::find($id);

        if ( $store->state == 0 ){
            Stores::destroy($id);
            $data = [
                'codigo' => 200,
                'msj' => "Almacen eliminado."
            ];
        }
        else {
            $data = [
                'codigo' => 500,
                'msj' => "No se eliminó, el almacen esta en uso."
            ];
        }

        return response()->json($data);
       
    }
}
