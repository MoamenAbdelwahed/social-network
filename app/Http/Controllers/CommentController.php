<?php
namespace App\Http\Controllers;

use App\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller{
	public function postCreateComment(Request $request){
		$this->validate($request,[
			'body' => 'required'
			]);
		$comment = new Comment();
		$comment->body = $request['body'];
		$comment->post_id = $request['postId'];
		$comment->user_id = $request['userId'];

		if($comment->save()){
			$message = "Your comment successfully created";
		}
		return redirect()->route('dashboard')->with(['message' => $message]);
	}
}