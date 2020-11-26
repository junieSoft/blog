<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\APIError;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = Product::simplePaginate($request->has('limit') ? $request->limit : 15);
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
            'price'=>'required',
            'categorie_id'=>'required'
        ]);
        $data = [];
        $data = array_merge($data, $request->only([
            'name',
            'price',
            'description',
            'imageD',
            'imageG',
            'imageH',
            'imageB',
            'categorie_id'
        ]));

        $path1 = " ";
        if(isset($request->imageD)){
            $imageD = $request->file('imageD');
            if($imageD != null){
                $extension = $imageD->getClientOriginalExtension();
                $relativeDestination = "uploads/Product";
                $destinationPath = public_path($relativeDestination);
                $saveName = "imageDroite".time().'.'.$extension;
                $imageD->move($destinationPath, $saveName);
                $path1 = "$relativeDestination/$saveName";
            }
        }

        $data['imageD'] = $path1;

        $path2 = " ";
        if(isset($request->imageG)){
            $imageG = $request->file('imageG');
            if($imageG != null){
                $extension = $imageG->getClientOriginalExtension();
                $relativeDestination = "uploads/Product";
                $destinationPath = public_path($relativeDestination);
                $saveName = "imageGauche".time().'.'.$extension;
                $imageG->move($destinationPath, $saveName);
                $path2 = "$relativeDestination/$saveName";
            }
        }

        $data['imageG'] = $path2;

        $path3 = " ";
        if(isset($request->imageH)){
            $imageH = $request->file('imageH');
            if($imageH != null){
                $extension = $imageH->getClientOriginalExtension();
                $relativeDestination = "uploads/Product";
                $destinationPath = public_path($relativeDestination);
                $saveName = "imageHaute".time().'.'.$extension;
                $imageH->move($destinationPath, $saveName);
                $path3 = "$relativeDestination/$saveName";
            }
        }

        $data['imageH'] = $path3;

        $path4 = " ";
        if(isset($request->imageB)){
            $imageB = $request->file('imageB');
            if($imageB != null){
                $extension = $imageB->getClientOriginalExtension();
                $relativeDestination = "uploads/Product";
                $destinationPath = public_path($relativeDestination);
                $saveName = "imageBasse".time().'.'.$extension;
                $imageB->move($destinationPath, $saveName);
                $path4 = "$relativeDestination/$saveName";
            }
        }

        $data['imageB'] = $path4;

        $product = Product::create($data);
        Return response()->json($product);

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
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = Product::find($id);
        if (!$product) {
            $error = new APIError;
            $error->setStatus("404");
            $error->setCode("product not found");
            $error->setMessage("l'id $id que vous rechercez n'existe pas!!!");
            return response()->json($error, 404);
        }
        
        return response()->json($product);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $product = Product::find($id);
        if (!$product) {
            $error = new APIError;
            $error->setStatus("404");
            $error->setCode("product not found");
            $error->setMessage("l'id $id que vous rechercez n'existe pas!!!");
            return response()->json($error, 404);
        }

        $data = [];
        $data = array_merge($data, $request->only([
            'name',
            'price',
            'description',
            'imageD',
            'imageG',
            'imageH',
            'imageB'
        ]));
        $product->name = $data['name'];
        $product->price = $data['prince'];
        $product->description = $data['description'];
        $product->imageD = $data['imageD'];
        $product->imageG = $data['imageG'];
        $product->imageH = $data['imageH'];
        $product->imageB = $data['imageB'];
        $product->update();
        return response()->json($product);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::find($id);
        if (!$product) {
            $error = new APIError;
            $error->setStatus("404");
            $error->setCode("product not found");
            $error->setMessage("l'id $id que vous rechercez n'existe pas!!!");
            return response()->json($error, 404);
        }
        
        $product->delete();
        return response()->json('ok!');

    }
}
