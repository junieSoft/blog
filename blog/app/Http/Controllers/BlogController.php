<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;
use App\Models\APIError;
use App\Http\Controllers\Controller;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = Blog::simplePaginate($request->has('limit') ? $request->limit : 15);
        foreach($data as $img){
            $img->image = url($img->image);
        }
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
            'blog_categorie_id'=>'required'
        ]);
        $data = [];
        $data = array_merge($data, $request->only([
            'name',
            'description',
            'image',
            'blog_categorie_id'
        ]));

        $path1 = " ";
        if(isset($request->image)){
            $image = $request->file('image');
            if($image != null){
                $extension = $image->getClientOriginalExtension();
                $relativeDestination = "uploads/Image";
                $destinationPath = public_path($relativeDestination);
                $saveName = "image".time().'.'.$extension;
                $image->move($destinationPath, $saveName);
                $path1 = "$relativeDestination/$saveName";
            }
        }

        $data['image'] = $path1;


        $blog = Blog::create($data);
        Return response()->json($blog);
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
     * @param  \App\Models\Blog  $blog
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $blog = Blog::find($id);
        if (!$blog) {
            $error = new APIError;
            $error->setStatus("404");
            $error->setCode("blog not found");
            $error->setMessage("l'id $id que vous rechercez n'existe pas!!!");
            return response()->json($error, 404);
        }

        $blog->image = url($blog->image);
        $nbComment = Comment::select(Comment::raw('count(*) as total'))->whereBlogId($id)->first();
        $blog->nbComment=$nbComment->total;
        $data = Blog::select('blogs.image','blogs.created_at','blog_categories.id as id_categorie','blog_categories.name','blog_categories.description')
        ->join('blog_categories','blogs.blog_categorie_id','=','blog_categories.id')
        ->where(['blog_categories.id' => $blog->blog_categorie_id])
        ->orderBy('created_at', 'desc')
        ->get();
            foreach($data as $date){
                $date->image = url($date->image);
            }
        $blog->blog=$data;
        $comment = Comment::whereBlogId($id)->orderBy('created_at', 'desc')->first();

        $blog->comment=$comment;

        
        return response()->json($blog);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Blog  $blog
     * @return \Illuminate\Http\Response
     */
    public function edit(Blog $blog)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Blog  $blog
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $blog = Blog::find($id);
        if (!$blog) {
            $error = new APIError;
            $error->setStatus("404");
            $error->setCode("blog not found");
            $error->setMessage("l'id $id que vous rechercez n'existe pas!!!");
            return response()->json($error, 404);
        }

        $data = [];
        $data = array_merge($data, $request->only([
            'name',
            'description',
            'image',
            'blog_categorie_id'
        ]));


        $path1 = " ";
        if(isset($request->image)){
            $image = $request->file('image');
            if($image != null){
                $extension = $image->getClientOriginalExtension();
                $relativeDestination = "uploads/Image";
                $destinationPath = public_path($relativeDestination);
                $saveName = "image".time().'.'.$extension;
                $image->move($destinationPath, $saveName);
                $path1 = "$relativeDestination/$saveName";
            }
        }
        $data['image'] = $path1;

        $blog->name = $data['name'];
        $blog->description = $data['description'];
        $blog->image = $data['image'];
        $blog->blog_categorie_id = $data['blog_categorie_id'];
        $blog->update();
        return response()->json($blog);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Blog  $blog
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $blog = Blog::find($id);
        if (!$blog) {
            $error = new APIError;
            $error->setStatus("404");
            $error->setCode("blog not found");
            $error->setMessage("l'id $id que vous rechercez n'existe pas!!!");
            return response()->json($error, 404);
        }
        
        $blog->delete();
        return response()->json('Element suprimé avec succès!!!');
    }
}
