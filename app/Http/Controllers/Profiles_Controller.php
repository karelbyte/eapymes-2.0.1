<?php

namespace App\Http\Controllers;

use App\Models\Modules;
use App\Models\Profile_Details;
use App\Models\Profiles;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class Profiles_Controller extends Controller
{
    public function lists(Request $request)
    {
        $skip =$request['start'] * $request['take'];
        $profiles = DB::table('profiles');
        $filtros = json_decode($request['fillter'], true);
        $order = json_decode($request['order'], true);
        if ( $filtros['name'] !== "" )  $profiles->where('name', 'LIKE',  "%".$filtros['name']."%");
        $profiles->orderby($order['field'], $order['type'] );
        $total =  $profiles->select('id', 'name')->count();
        $proslist =  $profiles->skip($skip)->take($request['take'])->get();
        $modules = Modules::all();
        $result = [
            'total' => $total,
            'data' => $proslist,
            'modules' => $modules
        ];
        return response()->json($result);
    }

    public function index(Request $request)
    {
        return view('profiles.index');
    }


    public function show($id)
    {
        $result = [
            'profile' => Profiles::find($id),
            'profile_details' => DB::table('profile_details')->select('idmodule')->where('idprofile', '=', $id)->get(),
        ];
        return response()->json($result);
    }


    public function store(Requests\Profile_Request $Request)
    {
        $pro = new Profiles();
        $pro->name = $Request->input('name');
        $pro->save();
        foreach ($Request->input('permits') as $permit)
        {
            Profile_Details::create([
                'idprofile' => $pro->id,
                'idmodule' => $permit]);
        };
        $data = [
            'codigo' => 'ok',
            'msj' => "Perfil creado correctamente."
        ];
        return response()->json($data);
    }

    public function pdf(){
        $pdf = \App::make('dompdf.wrapper');
        $pros = Profiles::all();
        $data = [
            'pros' => $pros,
            'permits' => $permit= DB::table('pros_permits')
                ->join('modules', 'pros_permits.id_modules', '=', 'modules.id')
                ->select('modules.descrip', 'pros_permits.id_pros')
                ->get(),
        ];
        $view = \View::make('pros.pdf',$data)->render();
        $pdf->loadHTML($view);
        return $pdf->stream('Perfiles.pdf');
    }


    public function edit($id)
    { }


    public function update(Requests\Profile_Update_Request $request, $id)
    {
        if ( is_null( DB::table('profiles')->where('name',  $request['name'])->where('id', '<>', $id)->first())){

            $pro = Profiles::find($id);
            $pro->name = $request['name'];
            $pro->save();
            DB::table('profile_details')->where('idprofile', '=', $id)->delete();
            foreach ($request->input('permits') as $permit) {
               Profile_Details::create([
                    'idprofile' => $id,
                    'idmodule' => $permit]);
            };
            $data = [
                'codigo' => 200,
                'msj' => "Datos actualizados correctamente."
            ];
        }
        else {
            $data = [
                'codigo' => 500,
                'msj' => "El perfil ya existe."
            ];
        }

        return response()->json($data);
    }

    public function eraser($id)
    {

    }


    public function destroy($id)
    {
        if ( is_null(DB::table('users')->where('idprofile',  $id)->first())){
            Profiles::destroy($id);
            $data = [
                'codigo' => 200,
                'msj' => "Perfil eliminado."
            ];
        }
        else {
            $data = [
                'codigo' => 500,
                'msj' => "No se eliminó, el perfil esta en uso."
            ];
        }

        return response()->json($data);
    }

}
