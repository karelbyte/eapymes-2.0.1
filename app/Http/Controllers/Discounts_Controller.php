<?php

namespace App\Http\Controllers;

use App\Models\Discounts;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class Discounts_Controller extends Controller
{
    public function index()
    {
        return view('discounts.index');
    }

    public function lists(Request $request)
    {
        $skip =$request['start'] * $request['take'];
        $discounts = DB::table('discounts');
        $filtros = json_decode($request['fillter'], true);
        $order = json_decode($request['order'], true);
        if ( $filtros['name'] !== "" ) $discounts->where('name' , 'LIKE',  "%".$filtros['name']."%");
        $discounts->orderby($order['field'], $order['type'] );
        $total =  $discounts->select('id', 'name', 'percent')->count();
        $list =  $discounts->skip($skip)->take($request['take'])->get();
        $result = [
            'total' => $total,
            'data' =>  $list
        ];
        return response()->json($result);
    }


    public function store(Requests\Discounts_Request $request)
    {
        if (is_numeric($request->input('percent'))){
            try {
                $ds = new Discounts();
                $ds->name = $request->input('name');
                $ds->percent = $request->input('percent');
                $ds->save();
                $data = [
                    'codigo' => 200,
                    'msj' => "Descuento creado correctamente."
                ];
            } catch (\Exception $e) {
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

    public function show($id)
    {
        $ds = Discounts::select('id', 'name', 'percent')->where('id', $id)->first();
        return response()->json($ds);
    }

    public function update(Requests\Discounts_Update_Request $request, $id)
    {
        if (is_numeric($request->input('percent'))){
            try {
                if ( is_null(DB::table('discounts')->where('name',  $request['name'])->where('id', '<>', $id)->first())){
                    $ds = Discounts::find($id);
                    $ds->name = $request->input('name');
                    $ds->percent = $request->input('percent');
                    $ds->save();
                    $data = [
                        'codigo' => 200,
                        'msj' => "Datos actualizados correctamente."
                    ];
                }
                else { return response()->json(["name" => ["El descuento ya existe."]], 442);
                }
            }
            catch (\Exception $e)
            {
                $data = [
                    'codigo' => 500,
                    'msj' => "A ocurrido un error!"  ];
            }
        } else {
            return response()->json(["percent" => ["Porciento no valido."]], 442);
        }
        return response()->json($data);
    }


    public function destroy($id)
    {
        try{
            Discounts::destroy($id);
            $data = [
                'codigo' => 200,
                'msj' => "Descuento eliminado."
            ];
        } catch (QueryException $e ){
            $data = [
                'codigo' => 500,
                'msj' => 'No se eliminó, el descuento esta en uso!'
            ];}
        catch (\Exception $e ){
            $data = [
                'codigo' => 500,
                'msj' => "A ocurrido un error!"
            ];
        }

        return response()->json($data);
    }
}
