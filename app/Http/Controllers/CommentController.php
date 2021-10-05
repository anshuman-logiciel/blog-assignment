<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Comment;
use App\Transformers\CommentTransformer;

class CommentController extends BaseController
{
    public function create_comment(Request $request)
    {
        $validator = Validator::make ($request->all(),[
            'description'=>'required|max:200',            
        ]);
        if($validator->fails())
        {
            return response()->json($validator->errors(),412);
        }               
        $parent_id=$request->parent_id; 
        $comment= Comment::where('id', $parent_id)->first();
        if($comment)
        {
            if($data=$comment->replylimit)
            {
                if($data->replylimit)
                {
                    return response()->json(["message"=>'error'],412);
                }
            }
        }
        $comments= new Comment;
        $comments->description=$request->description;
        $comments->post_id=$request->post_id;
        $comments->created_by=auth()->user()->id;
        $comments->parent_id=$request->parent_id;

        $comments->save();
        return [
            "message"=>'comment created successfully',
            "data"=>$this->item($comments, new CommentTransformer)]; 
    }   
    public function update_comment(Request $request, $id)
    {
        $comments=Comment::find($id);
        if($comments)
        {
            $validator= Validator::make($request->all(),[
                'description'=>'required|max:200',
                ]);
            if($validator->fails()){
                return response()->json($validator->errors(),412);
            }
            $comments->description=$request->description;
            $comments->post_id=$request->post_id;

            $comments->save();
            return[
                "message"=>'comment updated successfully',
                "data"=>$this->item($comments, new CommentTransformer)];
        }
        return response()->json(["message"=>'comment not found'],404);
    }
    public function delete_comment($id)
    {
        $comments=Comment::find($id);
        if($comments)
        {
            $comments->delete();
            return response()->json(["message"=>'comment deleted'],200); 
        }
        return response()->json(["message"=>'comment not found'],404);
    }
   public function index()
   {
        $comments=Comment::all();
        return $this->collection($comments , new CommentTransformer);
   }
}
