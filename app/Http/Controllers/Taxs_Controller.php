<?php

namespace App\Http\Controllers;

use App\Models\Taxs;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class Taxs_Controller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('taxs.index');
    }

    public function lists(Request $request)
    {
        $skip =$request['start'] * $request['take'];
        $taxs = DB::table('taxs');
        $filtros = json_decode($request['fillter'], true);
        $order = json_decode($request['order'], true);
        if ( $filtros['name'] !== "" ) $taxs->where('name', 'LIKE',  "%".$filtros['name']."%");
        //  if ( $filtros['percent'] !== "" ) $taxs->where('percent',  $filtros['percent']);
        $taxs->orderby($order['field'], $order['type'] );
        $total =  $taxs->select('id', 'name', 'percent')->count();
        $list =  $taxs->skip($skip)->take($request['take'])->get();
        $result = [
            'total' => $total,
            'data' =>  $list
        ];
        return response()->json($result);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Requests\Taxs_Request $request)
    {
        if (is_numeric($request->input('percent'))){
            try{
                $ds = new Taxs();
                $ds->name = $request->input('name');
                $ds->percent = $request->input('percent');
                $ds->save();
                $data = [
                    'codigo' => 200,
                    'msj' => "Impuesto creado correctamente."
                ];
            } catch (\Exception $e){
                $data = [
                    'codigo' => 500,
                    'msj' => "A ocurrido un error!"
                ];
            }

        } else
        {
            return response()->json(["percent" => ["Porciento no valido."]], 442);
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
        $ds = Taxs::select('id', 'name', 'percent')->where('id', $id)->first();
        return response()->json($ds);
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
    public function update(Requests\Taxs_Update_Request $request, $id)
    {
        if (is_numeric($request->input('percent'))){
            try {
                if ( is_null(DB::table('taxs')->where('name',  $request['name'])->where('id', '<>', $id)->first())){
                    $ds = Taxs::find($id);
                    $ds->name = $request->input('name');
                    $ds->percent = $request->input('percent');
                    $ds->save();
                    $data = [
                        'codigo' => 200,
                        'msj' => "Datos actualizados correctamente."
                    ];
                }
                else { return response()->json(["name" => ["El impuesto ya existe."]], 442);
                }
            }
            catch (\Exception $e)
            {
                $data = [
                    'codigo' => 500,
                    'msj' => "A ocurrido un error!"  ];
            }}
        else
        {
            return response()->json(["percent" => ["Porciento no valido."]], 442);
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
            Taxs::destroy($id);
            $data = [
                'codigo' => 200,
                'msj' => "Impuesto eliminado."
            ];
        }
        catch (QueryException $e ){
            $data = [
                'codigo' => 500,
                'msj' => 'No se eliminó, el impuesto esta en uso!'
            ];
        }
        catch (\Exception $e ){
            $data = [
                'codigo' => 500,
                'msj' => "A ocurrido un error!"
            ];
        }

        return response()->json($data);
    }
}
