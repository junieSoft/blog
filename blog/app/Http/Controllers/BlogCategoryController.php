<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\BlogCategory;
use App\Models\Blog;
use App\Models\APIError;

class BlogCategoryController extends Controller
{
       // Fonction pour lister les éléments de la table
    public function index(Request $request)
    {
        $data = BlogCategory::orderBy('created_at', 'desc')->simplePaginate($request->has('limit') ? $request->limit : 15);
        foreach($data as $date){
            $nbblog = Blog::select(Blog::raw('count(*) as total'))
                 ->whereBlogCategorieId($date->id)->first();
            $date->nbblog=$nbblog->total;
        }
        return response()->json($data);
    }
    
    //rechercher un élément 
    public function search(Request $request)
    {
        $this->validate($request->all(), [
            'q' => 'present',
            'field' => 'present'
        ]);

        $data = BlogCategory::where($request->field, 'like', "%$request->q%")->orderBy('created_at', 'desc')->get();
        foreach($data as $dat){
            $nbblog = Blog::select(Blog::raw('count(*) as total'))
                 ->whereBlogCategorieId($dat->id)->first();
            $dat->nbblog=$nbblog->total;
        }
      
        return response()->json($data);
    }

    // fonction pour ajouter un élément dans la table
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
        $blogcategory = BlogCategory::create($data);
        Return response()->json($blogcategory);
    }

    public function update(Request $request, $id)
    {
        $blogcategory = BlogCategory::find($id);
        if (!$blogcategory) {
            $error = new APIError;
            $error->setStatus("404");
            $error->setCode("blogcategory not found");
            $error->setMessage("l'id $id que vous rechercez n'existe pas!!!");
            return response()->json($error, 404);
        }

        $data = [];
        $data = array_merge($data, $request->only([
            'name',
            'description'
        ]));
        $blogcategory->name = $data['name'];
        $blogcategory->description = $data['description'];
        $blogcategory->update();
        return response()->json($blogcategory);
    }

    public function find($id)
    {
        $blogcategory = BlogCategory::find($id);
        if (!$blogcategory) {
            $error = new APIError;
            $error->setStatus("404");
            $error->setCode("blogcategory not found");
            $error->setMessage("l'id $id que vous rechercez n'existe pas!!!");
            return response()->json($error, 404);
        }
        
        $BlogCategorie->blogs = $data;

        return response()->json($blogcategory);
    }

    public function delete($id)
    {
        $blogcategory = BlogCategory::find($id);
        if (!$blogcategory) {
            $error = new APIError;
            $error->setStatus("404");
            $error->setCode("blogcategory not found");
            $error->setMessage("l'id $id que vous rechercez n'existe pas!!!");
            return response()->json($error, 404);
        }
        
        $blogcategory->delete();
        return response()->json('ok!');
    }

}
