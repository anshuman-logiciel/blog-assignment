<?php
namespace App\Transformers;

use App\Models\Comment;
use Illuminate\Database\Eloquent\Collection;
use League\Fractal\TransformerAbstract;

class CommentTransformer extends TransformerAbstract
{
	//protected $availableIncludes = ['reply'];

	protected $defaultIncludes = ['reply'];

	public function transform(Comment $comments)
	{
		return[
            'id' 	=> $comments->id,
			'parent_id'=>$comments->parent_id,
            'description'=> $comments->description,
			'post_id' =>$comments->post_id,
			'created_by'=>$comments->created_by,
            'created_at' => $comments->created_at->format('Y-m-d' . 'h:m:s'),
      		'updated_at' => $comments->updated_at->format('Y-m-d' . 'h:m:s'),
          
        ];
		
	}
	public function includeReply(Comment $comments)
	{
		$data = $comments->replies;
		return $this->collection($data , new CommentTransformer);
   
	}
}