<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\APIError;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = Category::simplePaginate($request->has('limit') ? $request->limit : 15);
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
            'name'=>'required'
        ]);
        $data = [];
        $data = array_merge($data, $request->only([
            'name',
            'description'
        ]));
        $category = Category::create($data);
        return response()->json($category);

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
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $category = Category::find($id);
        if (!$category) {
            $error = new APIError;
            $error->setStatus("404");
            $error->setCode("category not found");
            $error->setMessage("l'id $id que vous rechercez n'existe pas!!!");
            return response()->json($error, 404);
        }
        
        return response()->json($category);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $category = Category::find($id);
        if (!$category) {
            $error = new APIError;
            $error->setStatus("404");
            $error->setCode("category not found");
            $error->setMessage("l'id $id que vous rechercez n'existe pas!!!");
            return response()->json($error, 404);
        }

        $data = [];
        $data = array_merge($data, $request->only([
            'name',
            'description'
        ]));
        $category->name = $data['name'];
        $category->description = $data['description'];
        $category->update();
        return response()->json($category);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = Category::find($id);
        if (!$category) {
            $error = new APIError;
            $error->setStatus("404");
            $error->setCode("category not found");
            $error->setMessage("l'id $id que vous rechercez n'existe pas!!!");
            return response()->json($error, 404);
        }
        
        $blogcategory->delete();
        return response()->json('ok!');

    }
}
