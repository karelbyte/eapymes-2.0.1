<?php

namespace App\Http\Controllers;

use App\Models\Categories;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class Categories_Controller extends Controller
{
    public function lists(Request $request)
    {
        $skip =$request['start'] * $request['take'];
        $measures = DB::table('categories');
        $filtros = json_decode($request['fillter'], true);
        $order = json_decode($request['order'], true);
        if ( $filtros['name'] !== "" ) $measures->where('name', 'LIKE',  "%".$filtros['name']."%");
        $measures->orderby($order['field'], $order['type'] );
        $total =  $measures->select('id', 'name')->count();
        $list =  $measures->skip($skip)->take($request['take'])->get();
        $result = [
            'total' => $total,
            'data' =>  $list
        ];
        return response()->json($result);
    }

    public function index()
    {
        return view('categories.index');
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
    public function store(Requests\Categories_Request $request)
    {
        $unit = new Categories();
        $unit->name = $request->input('name');
        $unit->save();
        $data = [
            'codigo' => 'ok',
            'msj' => "Categoria creada correctamente."
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
        $measure = Categories::select('id', 'name')->where('id', $id)->first();
        return response()->json($measure);
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
    public function update(Requests\Categories_Update_Request $request, $id)
    {
        try {
            if ( is_null(DB::table('categories')->where('name',  $request['name'])->where('id', '<>', $id)->first())){
                $unit = Categories::find($id);
                $unit->name = $request->input('name');
                $unit->save();
                $data = [
                    'codigo' => 200,
                    'msj' => "Datos actualizados correctamente."
                ];
            }
            else {
                {
                    return response()->json(["name" => ["La categoria ya existe."]], 442);
                }
            }
        } catch (\Exception $e){
            $data = [
                'codigo' => 500,
                'msj' => "A ocurrido un error !!"
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
        try{
            Categories::destroy($id);
            $data = [
                'codigo' => 200,
                'msj' => "Categoria eliminada."
            ];
        } catch (QueryException $e ){
            $data = [
                'codigo' => 500,
                'msj' => 'No se eliminó, la categoria esta en uso!'
            ];
        } catch (\Exception $e ){
            $data = [
                'codigo' => 500,
                'msj' => 'A ocurrido un error !!'
            ];
        }
        return response()->json($data);
    }

}
