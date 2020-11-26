<?php

namespace App\Http\Controllers;

use App\Models\Promotion;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\APIError;

class PromotionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = Promotion::simplePaginate($request->has('limit') ? $request->limit : 15);
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
            'name'=>'required',
            'description'=>'required',
            'date_debut'=>'required',
            'date_fin'=>'required'
        ]);
        $data = [];
        $data = array_merge($data, $request->only([
            'name',
            'description',
            'date_debut',
            'date_fin'
        ]));
        $promotion = Promotion::create($data);
        Return response()->json($promotion);

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
     * @param  \App\Models\Promotion  $promotion
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $promotion = Promotion::find($id);
        if (!$promotion) {
            $error = new APIError;
            $error->setStatus("404");
            $error->setCode("promotion not found");
            $error->setMessage("l'id $id que vous rechercez n'existe pas!!!");
            return response()->json($error, 404);
        }
        
        return response()->json($promotion);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Promotion  $promotion
     * @return \Illuminate\Http\Response
     */
    public function edit(Promotion $promotion)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Promotion  $promotion
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $promotion = Promotion::find($id);
        if (!$promotion) {
            $error = new APIError;
            $error->setStatus("404");
            $error->setCode("promotion not found");
            $error->setMessage("l'id $id que vous rechercez n'existe pas!!!");
            return response()->json($error, 404);
        }

        $data = [];
        $data = array_merge($data, $request->only([
            'name',
            'description',
            'date_debut',
            'date_fin'
        ]));
        $promotion->name = $data['name'];
        $promotion->description = $data['description'];
        $promotion->date_debut = $data['date_debut'];
        $promotion->date_fin = $data['date_fin'];
        $promotion->update();
        return response()->json($promotion);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Promotion  $promotion
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $promotion = Promotion::find($id);
        if (!$promotion) {
            $error = new APIError;
            $error->setStatus("404");
            $error->setCode("promotion not found");
            $error->setMessage("l'id $id que vous rechercez n'existe pas!!!");
            return response()->json($error, 404);
        }
        
        $promotion->delete();
        return response()->json('ok!');

    }
}
