<?php
namespace App\Transformers;

use App\Models\Post;
use League\Fractal\TransformerAbstract;
use Symfony\Component\Routing\Loader\ProtectedPhpFileLoader;

class PostTransformer extends TransformerAbstract
{

   //protected $availableIncludes = ['comments'];

   protected $defaultIncludes = ['comments'];

	public function transform(Post $posts)
	{
		return[
            'id' 	=> $posts->id,
            'title'      => $posts->title,
            'description'=> $posts->description,
            'created_by' =>$posts->created_by,
            'created_at' => $posts->created_at->format('Y-m-d' . 'h:m:s'),
      		'updated_at' => $posts->updated_at->format('Y-m-d' . 'h:m:s'),          
        ];
	}
   public function includeComments(Post $posts)
   {
      $data = $posts->comments;
      return $this->collection($data , new CommentTransformer);
   }
}