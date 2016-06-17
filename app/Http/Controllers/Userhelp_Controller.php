<?php

namespace App\Http\Controllers;

use App\Models\Userhelp;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class Userhelp_Controller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
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
