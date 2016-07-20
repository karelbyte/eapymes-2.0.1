<?php

namespace App\Http\Controllers;

use App\Models\Discounts;
use App\Models\Product_Discounts;
use App\Models\Product_taxs;
use App\Models\Products;
use App\Models\Taxs;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class Products_Controller extends Controller
{
    public function lists(Request $request)
    {
        $skip =$request['start'] * $request['take'];
        $products = DB::table('products')
            ->join('categories', 'products.idcategorie', '=','categories.id')
            ->join('product_state', 'products.active', '=','product_state.id');
        $filtros = json_decode($request['fillter'], true);
        $order = json_decode($request['order'], true);
        if ( $filtros['code'] !== "" )  $products->where('products.code', 'LIKE',  "%".$filtros['code']."%");
        if ( $filtros['name'] !== "" )  $products->where('products.name', 'LIKE',  "%".$filtros['name']."%");
        if ( $filtros['price'] !== "" )  $products->where('products.price', $filtros['price']);
        if ( $filtros['idcategorie'] !== "" )  $products->where('products.idcategorie', '=',  $filtros['idcategorie']);
        if ( $filtros['active'] !== "" )  $products->where('products.active', '=',  $filtros['active']);
        $products->orderby($order['field'], $order['type'] );
        $products->select('products.id', 'products.name', 'products.code',  'categories.name as categories', 'product_state.state as state',DB::raw('format(products.price,2) as price'));
        $total =$products->count();
        $productslist = $products->skip($skip)->take($request['take'])->get();
        $categories =  DB::table('categories')->select('id', 'name')->get();
        $um =  DB::table('measures')->select('id', 'name')->get();
        $result = [
            'total' => $total,
            'categories' =>  $categories,
            'data' =>  $productslist,
            'um' =>  $um
        ];
        return response()->json($result);
    }

    public function index()
    {
        return view('products.index');
    }


    public function store(Requests\Products_Request $request)
    {
        $product= new Products();
        $product->name = $request->input('name');
        $product->code = strtoupper($request->input('code'));
        $product->idmeasure = $request->input('idmeasure');
        $product->idcategorie = $request->input('idcategorie');
        $product->price = $request->input('price');
        $product->service = $request->input('service');
        $product->storable = $request->input('storable');
        $product->saleable = $request->input('saleable');
        $product->produced = $request->input('produced');
        $product->purchase = $request->input('purchase');
        $product->reward = $request->input('reward');
        $product->mix = $request->input('mix');
        $product->active = $request->input('active');
        $product->save();
        $data = [
            'codigo' => 200,
            'msj' => "Producto creado correctamente."
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
        $product = Products::find($id);
        return response()->json($product);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */


    public function update(Requests\Products_Update_Request $request, $id)
    {
        try {
            if (is_null(DB::table('products')->where('code', $request['code'])->where('id', '<>', $id)->first())) {
                $product = Products::find($id);
                $product->name = $request->input('name');
                $product->code = strtoupper($request->input('code'));
                $product->idmeasure = $request->input('idmeasure');
                $product->idcategorie = $request->input('idcategorie');
                $product->price = $request->input('price');
                $product->service = $request->input('service');
                $product->storable = $request->input('storable');
                $product->saleable = $request->input('saleable');
                $product->produced = $request->input('produced');
                $product->purchase = $request->input('purchase');
                $product->reward = $request->input('reward');
                $product->mix = $request->input('mix');
                $product->active = $request->input('active');
                $product->save();
                $data = [
                    'codigo' => 200,
                    'msj' => "Datos actualizados correctamente."
                ];
            } else {
                return response()->json(["code" => ["El producto ya existe."]], 442);
            }
        }
        catch (\Exception $e)
        {
            $data = [
                'codigo' => 500,
                'msj' => "A ocurrido un error!"  ];
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
            Products::destroy($id);
            $data = [
                'codigo' => 200,
                'msj' => "Producto eliminado."
            ];
        } catch (QueryException $e ){
            $data = [
                'codigo' => 500,
                'msj' => 'No se eliminó, el producto esta en uso!'
            ];}
        catch (\Exception $e ){
            $data = [
                'codigo' => 500,
                'msj' => "A ocurrido un error!"
            ];
        }

        return response()->json($data);
    }

    // Codigo de descuentos

    public function discounts($id)
    {
        $dislist = Discounts::select('id', 'name')->orderby('name', 'asc')->get();
        $distrues = DB::table('product_discounts')
            ->select('iddiscount as id')->where('product_discounts.idproduct', '=', $id)->get();
        $result = [
            'dislist' => $dislist,
            'distrues' => $distrues
        ];
        return response()->json($result);
    }

    public function discountstores(Request $request)
    {
       try{
            DB::table('product_discounts')->where('idproduct', '=', $request['id'])->delete();
            foreach ($request->input('distrues') as $distrues)
            {
                Product_Discounts::create([
                    'idproduct' => $request['id'],
                    'iddiscount' => $distrues]);
            };
            $data = [
                'codigo' => 200,
                'msj' => "Datos actualizados correctamente."
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

    // codigo de impuestos
    public function taxs($id)
    {
        $taxlist = Taxs::select('id', 'name')->orderby('name', 'asc')->get();
        $taxstrue = DB::table('product_taxs')
            ->select('idtax as id')->where('product_taxs.idproduct', '=', $id)->get();
        $result = [
            'taxlist' => $taxlist,
            'taxstrue' => $taxstrue
        ];
        return response()->json($result);
    }

    public function taxsstores(Request $request)
    {
        DB::table('product_taxs')->where('idproduct', '=', $request['id'])->delete();
        foreach ($request->input('taxstrue') as $distrues)
        {
            Product_taxs::create([
                'idproduct' => $request['id'],
                'idtax' => $distrues]);
        };

        $data = [
            'codigo' => 200,
            'msj' => "Datos actualizados correctamente."
        ];

        return response()->json($data);
    }


 
}
