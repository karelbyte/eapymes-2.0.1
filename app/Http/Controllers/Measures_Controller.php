<?php

namespace App\Http\Controllers;

use App\Models\Measures;
use App\Models\Userhelp;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class Measures_Controller extends Controller
{
    public function lists(Request $request)
    {
        $skip =$request['start'] * $request['take'];
        $measures = DB::table('measures');
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
       return view('measures.index');
    }

    public function showhelp(Request $request)
    {
        $filtros = json_decode($request['user'], true);
        if ( is_null(DB::table('users_help')->where('iduser',  $filtros['id'])->where('idhelp', '=',  $filtros['idhelp'])->first())){
            $result = false; } else   $result = true;
        return response()->json($result);
    }

    public function showhelpoff(Request $request)
    {
        $filtros = json_decode($request['user'], true);
        $h = new Userhelp();
        $h->iduser = $filtros['id'];
        $h->idhelp = $filtros['idhelp'];
        $h->save();
    }

    public function store(Requests\Measures_Request $request)
    {
        $unit = new Measures();
        $unit->name = $request->input('name');
        $unit->save();
        $data = [
            'codigo' => 200,
            'msj' => "Medida creada correctamente."
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
        $measure = Measures::select('id', 'name')->where('id', $id)->first();
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
    public function update(Requests\Measures_Update_Request $request, $id)
    {
        try {
            if ( is_null(DB::table('measures')->where('name',  $request['name'])->where('id', '<>', $id)->first())){
                $unit = Measures::find($id);
                $unit->name = $request->input('name');
                $unit->save();
                $data = [
                    'codigo' => 200,
                    'msj' => "Datos actualizados correctamente."
                ];
            }
            else {
                {
                    return response()->json(["name" => ["La medida ya existe."]], 442);
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
            Measures::destroy($id);
            $data = [
                'codigo' => 200,
                'msj' => "Medida eliminada."
            ];
        } catch (QueryException $e ){
            $data = [
                'codigo' => 500,
                'msj' => 'No se eliminó, la medida esta en uso!'
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
