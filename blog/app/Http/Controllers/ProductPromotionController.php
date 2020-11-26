<?php

namespace App\Http\Controllers;

use App\Models\ProductPromotion;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\APIError;

class ProductPromotionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = ProductPromotion::simplePaginate($request->has('limit') ? $request->limit : 15);
        return response()->json($data);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $this->validate($request->all(), [
            'product_id'=>'required',
            'promotion_id'=>'required',
            'pourcentage'=>'required',
            'is_promo'=>'required'
        ]);
        $data = [];
        $data = array_merge($data, $request->only([
            'product_id',
            'promotion_id',
            'pourcentage',
            'is_promo'
        ]));

        $productPromotion = ProductPromotion::create($data);
        return response()->json($productPromotion);

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
     * @param  \App\Models\ProductPromotion  $productPromotion
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $productPromotion = ProductPromotion::find($id);
        if (!$productPromotion) {
            $error = new APIError;
            $error->setStatus("404");
            $error->setCode("productProduct not found");
            $error->setMessage("l'id $id que vous rechercez n'existe pas!!!");
            return response()->json($error, 404);
        }
        
        return response()->json($productPromotion);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ProductPromotion  $productPromotion
     * @return \Illuminate\Http\Response
     */
    public function edit(ProductPromotion $productPromotion)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ProductPromotion  $productPromotion
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $productPromotion = ProductPromotion::find($id);
        if (!$blogcategory) {
            $error = new APIError;
            $error->setStatus("404");
            $error->setCode("productpromotion not found");
            $error->setMessage("l'id $id que vous rechercez n'existe pas!!!");
            return response()->json($error, 404);
        }

        $data = [];
        $data = array_merge($data, $request->only([
            'product_id',
            'promotion_id',
            'pourcentage',
            'is_promo'
        ]));
        $productPromotion->product_id = $data['product_id'];
        $productPromotion->promotion_id = $data['promotion_id'];
        $productPromotion->pourcentage = $data['pourcentage'];
        $productPromotion->is_promo = $data['is_promo'];
        $productPromotion->update();
        return response()->json($productPromotion);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ProductPromotion  $productPromotion
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $productPromotion = ProductPromotion::find($id);
        if (!$productPromotion) {
            $error = new APIError;
            $error->setStatus("404");
            $error->setCode("productpromotion not found");
            $error->setMessage("l'id $id que vous rechercez n'existe pas!!!");
            return response()->json($error, 404);
        }
        
        $productPromotion->delete();
        return response()->json('ok!');

    }
}
