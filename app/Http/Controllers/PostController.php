<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Facades\Validator;   
use App\Transformers\PostTransformer;   
use League\Fractal;
use League\Fractal\Manager;


class PostController extends BaseController
{
    public function __construct()
    {          
        $fractal = new Fractal\Manager();
        

        if(isset($_GET['includes'])) {
            
        $fractal->parseIncludes($_GET['includes']);
        
    }
        
    }
    Public function create_data(Request $request)
    {
        //dd($posts=auth()->user()->id);
        //dd(auth()->user()->id);
        $validator = Validator::make($request->all(),[
            'title'=>'required|max:20|unique:posts',
            'description'=>'required|max:200',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(),412);
        }
        
            $posts = new Post;
            $posts->title=$request->title;
            $posts->description=$request->description;
            $posts->created_by=auth()->user()->id;

            $posts->save();

            return [
                "message"=>"data created successfully",
                "data"=>$this->item($posts, new PostTransformer)];
    }

    public function update_data(Request $request,$id)
    {
        $posts=Post::find($id);
        if($posts)
        {

            $validator = Validator::make($request->all(),[
            'title'=>'required|max:20|unique:posts,title,'."$id",
            'description'=>'required|max:200',
            ]);

        if($validator->fails()) {
            return response()->json($validator->errors(),412);
        }

            $posts->title=$request->title;
            $posts->description=$request->description;

            $posts->save();

            return [
                "message"=>"data updated successfully",
                "data"=>$this->item($posts ,new PostTransformer)];
        }
        return response()->json(['message'=>'post not found'],404);
            
    } 
    public function delete_data($id)
    {
        $posts=Post::find($id);
        if($posts)
        {
            $posts->delete();        
            return response()->json(['message'=>'record deleted'],200);
        }
            return response()->json(['message'=>'post not found'],404);
    }
    public function show($id)
    {
        $post = Post::find($id);

        return $this->item($post ,new PostTransformer);
    }
     public function index(Request $request)
     {
        $limit= $request->limit;
        $title= $request->title;
        $posts=Post::where('title','like','%' . $title  . '%' )->paginate($limit);

        return $this->collection($posts , new PostTransformer);
    }
    
}
