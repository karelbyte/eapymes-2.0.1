<?php

namespace App\Http\Controllers;

use App\Models\Shelves;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class Shelves_Controller extends Controller
{
    public function lists(Request $request)
    {
        $skip =$request['start'] * $request['take'];
        $shelves = DB::table('shelves')
            ->join('stores', 'shelves.idstore', '=','stores.id');
        $filtros = json_decode($request['fillter'], true);
        $order = json_decode($request['order'], true);
        if ( $filtros['name'] !== "" ) $shelves->where('shelves.name', 'LIKE',  "%".$filtros['name']."%");
        if ( $filtros['idstore'] !== "" ) $shelves->where('idstore', '=',  $filtros['idstore']);
        $shelves->orderby($order['field'], $order['type'] );
        $total = $shelves->select('shelves.id', 'shelves.name as name', 'stores.name as store')->count();
        $shelveslist = $shelves->skip($skip)->take($request['take'])->get();
        $datastore =  DB::table('stores')->select('id', 'name')->get();

        $result = [
            'total' => $total,
            'stores' => $datastore,
            'data' => $shelveslist
        ];
        return response()->json($result);
    }

    public function index()
    {
        return view('shelves.index');
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

    public function store(Requests\Shelves_Request $request)
    {
        if ( is_null( DB::table('shelves')->where('name',  $request['name'])->where('idstore',  $request->input('idstore'))->first() )) {
            $shelve = new Shelves();
            $shelve->idstore = $request->input('idstore');
            $shelve->name = $request->input('name');
            $shelve->save();
            $data = [
                'codigo' => 200,
                'msj' => "Estante creado correctamente."
            ];
        }
        else{
            $data = [
                'codigo' => 500,
                'msj' => "El estante ya existe para este almacen."
            ];
        }
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
        $shelve = Shelves::find($id);
        return response()->json($shelve);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    { }


    public function update(Requests\Shelves_Update_Request $request, $id)
    {
        if ( is_null( DB::table('shelves')->where('name',  $request['name'])->where('id', '<>', $id)->where('idstore',$request->input('idstore'))->first())){
            $shelve =  Shelves::find($id);
            $shelve->idstore = $request->input('idstore');
            $shelve->name = $request->input('name');
            $shelve->save();
            $data = [
                'codigo' => 200,
                'msj' => "Datos actualizados correctamente."
            ];
        }
        else {
            $data = [
                'codigo' => 500,
                'msj' => "El estante ya existe para este almacen."
            ];
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
        Shelves::destroy($id);
        $data = [
            'codigo' => 'ok',
            'msj' => "Estante eliminado."
        ];

        return response()->json($data);
    }
}
