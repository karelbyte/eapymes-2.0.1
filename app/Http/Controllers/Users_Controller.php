<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class Users_Controller extends Controller
{
    public function lists(Request $request)
    {
        $skip =$request['start'] * $request['take'];
        $users = DB::table('users')
            ->join('profiles', 'profiles.id', '=','users.idprofile')
            ->join('persons', 'users.idperson', '=','persons.id')
            ->join('product_state', 'users.active', '=','product_state.id');
        $filtros = json_decode($request['fillter'], true);
        $order = json_decode($request['order'], true);
        if ( $filtros['nick'] !== "" ) $users->where('nick', 'LIKE',  "%".$filtros['nick']."%");
        if ( $filtros['name'] !== "" ) $users->where('persons.name', 'LIKE',  "%".$filtros['name']."%");
        if ( $filtros['idprofile'] !== "" ) $users->where('idprofile', '=',  $filtros['idprofile']);

        $users->orderby($order['field'], $order['type'] );
        $total = $users->select('users.id', 'persons.name', 'users.nick', 'profiles.name as profile', 'product_state.state as state')->count();
        $userslist = $users->skip($skip)->take($request['take'])->get();
        $datarolls =  DB::table('profiles')->select('id', 'name')->get();
        $datapersons = DB::table('persons')->select('persons.id', 'persons.name')->where('idtype', '=', '1')->where('active', '=', '1') ->get();
        $result = [
            'total' => $total,
            'data' =>  $userslist,
            'profiles' => $datarolls,
            'datapersons' => $datapersons
        ];
        return response()->json($result);
    }

    public function index()
    {
        return view('users.index');
    }


    public function create()
    { }


    public function store(Requests\Users_Request $Request)
    {
        $user = new User();
        $user->idperson = $Request->input('idperson');
        $user->nick = $Request->input('nick');
        $user->idprofile = $Request->input('idprofile');
        $user->password = bcrypt($Request['password']);
        $user->active =  $Request->input('active');
        $user ->save();
        $data = [
            'codigo' => 200,
            'msj' => "Usuario creado correctamente."
        ];
        return response()->json($data);
    }

    public function show($id)
    {
        $user = User::find($id);
        return response()->json($user);
    }

    public function edit($id)
    {

    }

    public function update(Requests\Users_Update_Request $request, $id)
    {
        if ( is_null( DB::table('users')->where('nick',  $request['nick'])->where('id', '<>', $id)->first())){
            $user = User::find($id);
            $user->idperson = $request->input('idperson');
            $user->nick = $request->input('nick');
            $user->idprofile = $request->input('idprofile');
            //  if (!is_null($request['password']) & $request['password'] == "") $user->password = bcrypt($request['password']);
            if ($request['password'] != "") $user->password = bcrypt($request['password']);
            $user->active =  $request->input('active');
            $user->save();
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

    public function destroy($id)
    {
        /*   if ( is_null(DB::table('users')->where('idroll',  $id)->first())){
               User::destroy($id);
               $data = [
                   'codigo' => 'ok',
                   'msj' => "Usuario eliminado."
               ];
           }
           else {
               $data = [
                   'codigo' => 'error',
                   'msj' => "No se eliminó, el usuario esta en uso."
               ];
           }
   */     User::destroy($id);
        $data = [
            'codigo' => 200,
            'msj' => "Usuario eliminado."
        ];
        return response()->json($data);
    }

    public function eraser($id)
    { }

    public function login(){
        return view('users.login');
    }

    public function pdf(){
        $pdf = \App::make('dompdf.wrapper');
        $users =  DB::table('users')
            ->join('rolls', 'users.idroll', '=', 'rolls.id')
            ->join('persons', 'users.idperson', '=', 'persons.id')
            ->select('persons.name as nombre','users.nick as alias', 'rolls.descrip as perfil')
            ->orderBy('users.nick', 'asc')->get();
        $view = \View::make('users.pdf', compact('users'))->render();
        $pdf->loadHTML($view);
        return $pdf->stream('Usuarios.pdf');
    }
}
