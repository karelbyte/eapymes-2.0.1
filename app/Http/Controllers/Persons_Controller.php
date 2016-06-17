<?php

namespace App\Http\Controllers;

use App\Models\Persons;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;


class Persons_Controller extends Controller
{
    public function lists(Request $request)
    {
        $skip =$request['start'] * $request['take'];
        $persons = DB::table('persons')
            ->join('person_types', 'persons.idtype', '=','person_types.id')
            ->join('product_state', 'persons.active', '=','product_state.id');
        $filtros = json_decode($request['fillter'], true);
        $order = json_decode($request['order'], true);
        if ( $filtros['name'] !== "" ) $persons->where('persons.name', 'LIKE',  "%".$filtros['name']."%");
       /* if ( $filtros['idtype'] !== "" ) $persons->where('idtype', '=',  $filtros['idtype']);
        if ( $filtros['address'] !== "" ) $persons->where('address', 'LIKE',  "%".$filtros['address']."%");
        if ( $filtros['state'] !== "" ) $persons->where('active', '=',  $filtros['state']);*/
        $persons->orderby($order['field'], $order['type'] );
        $total = $persons->select('persons.id', 'persons.pic','persons.name', 'persons.address', 'person_types.name as type', 'product_state.state as state')->count();
        $personslist = $persons->skip($skip)->take($request['take'])->get();
        $datareason =  DB::table('person_reasons')->select('id', 'name')->get();
        $datatype = DB::table('person_types')->select('id', 'name')->get();
        $datastate = DB::table('product_state')->select('id', 'state')->get();
        $result = [
            'total' => $total,
            'state' => $datastate,
            'reasons' => $datareason,
            'types' => $datatype,
            'data' => $personslist
        ];
        return response()->json($result);
    }

    public function index()
    {
        return view('persons.index');
    }


    public function store(Requests\Persons_Request $Request)
    {
        \Storage::copy($Request->input('pic'), str_replace(' ', '', $Request->input('name')));
        Storage::delete($Request->input('pic'));
        $person = new Persons();
        $person->idreason = $Request->input('idreason');
        $person->pic = str_replace(' ', '', $Request->input('name'));
        $person->idtype = $Request->input('idtype');
        $person->name = $Request->input('name');
        $person->comercial_name = $Request->input('comercial_name');
        $person->address = $Request->input('address');
        $person->zip = $Request->input('zip');
        $person->state = $Request->input('state');
        $person->country = $Request->input('country');
        $person->phone = $Request->input('phone');
        $person->cell = $Request->input('cell');
        $person->email = $Request->input('email');
        $person->rfc = $Request->input('rfc');
        $person->curp = $Request->input('curp');
        $person->active = $Request->input('active');
        $person->save();
        $data = [
            'codigo' => 200,
            'msj' => "Persona creada correctamente."
        ];
        return response()->json($data);
    }

    public function show($id)
    {
        $persona = Persons::find($id);
        return response()->json($persona);
    }


    public function update(Requests\Persons_Update_Request $Request, $id)
    {

        if ( is_null( DB::table('persons')->where('name',  $Request->input('name'))->where('id', '<>', $id)->first())){
            $person = Persons::find($id);

            if ($person->pic !== $Request->input('pic')){
                \Storage::copy($Request->input('pic'), str_replace(' ', '', $Request->input('name')));
                $person->pic = str_replace(' ', '', $Request->input('name'));
            }
            $person->idreason = $Request->input('idreason');
            $person->idtype = $Request->input('idtype');
            $person->name = $Request->input('name');
            $person->comercial_name = $Request->input('comercial_name');
            $person->address = $Request->input('address');
            $person->zip = $Request->input('zip');
            $person->state = $Request->input('state');
            $person->country = $Request->input('country');
            $person->phone = $Request->input('phone');
            $person->cell = $Request->input('cell');
            $person->email = $Request->input('email');
            $person->rfc = $Request->input('rfc');
            $person->curp = $Request->input('curp');
            $person->active = $Request->input('active');
            $person->save();
            $data = [
                'codigo' => 200,
                'msj' => "Datos actualizados correctamente."
            ];
        }
        else {
            $data = [
                'codigo' => 500,
                'msj' => "La persona ya existe."
            ];
        }

        return response()->json($data);

    }

    public function destroy($id)
    {
        if ( is_null(DB::table('users')->where('idperson',  $id)->first())){
            $persona = Persons::find($id);
            \Storage::delete($persona->pic);
            Persons::destroy($id);
            $data = [
                'codigo' => 200,
                'msj' => "Persona eliminada."
            ];
        }
        else {
            $data = [
                'codigo' => 500,
                'msj' => "No se eliminó, la persona esta en uso."
            ];
        }

        return response()->json($data);
    }


    public function saveimg(Request $request)
    {
        $file = $request->file('file');
        //$nombre = $file->getClientOriginalName();
        $nombre =  $request['name'];
        \Storage::disk('local')->put($nombre,  \File::get($file));
        return "archivo guardado";
    }


}