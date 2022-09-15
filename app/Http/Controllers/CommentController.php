<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;

class CommentController extends Controller
{
    public function store(Request $request)
    {
        $image = $request->file('json_data');
        $destinationPath = 'data/';
        $profileImage = date('YmdHis') . "." . $image->getClientOriginalExtension();
        $image->move($destinationPath, $profileImage);
          
        $data = json_decode(file_get_contents($destinationPath . $profileImage), true);

        for($i=0; $i<count($data['comments']); $i++) {
            $exitComment = Comment::where('id',$data['comments'][$i]['id'])->first();
            if(!$exitComment) {
                $new_comment = new Comment();
                $new_comment->postId = $data['comments'][$i]['postId'];
                $new_comment->body = $data['comments'][$i]['body'];
                $new_comment->user = [
                    "id" => $data['comments'][$i]['user']['id'],
                    "username" => $data['comments'][$i]['user']['username']
                ];
                $new_comment->save();
            }else {
                $exitComment->postId = $data['comments'][$i]['postId'];
                $exitComment->body = $data['comments'][$i]['body'];
                $exitComment->user = [
                    "id" => $data['comments'][$i]['user']['id'],
                    "username" => $data['comments'][$i]['user']['username']
                ];
                $exitComment->save(); 
            }
            
        }
        return back();
    }
}
