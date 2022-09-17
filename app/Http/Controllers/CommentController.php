<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use App\Models\Post;
use App\Models\User;

class CommentController extends Controller
{
    public function index()
    {
        return view('comments');
    }

    public function details(Request $request)
    {
        $comments = Comment::paginate(20);
        if($request->keyword != ''){
            $comments = Comment::where('body','LIKE','%'.$request->keyword.'%')->paginate(20);
        }

        return response()->json([
            'comments' => $comments
        ]);
    }

    public function store(Request $request)
    {
        $image = $request->file('json_data');
        $destinationPath = 'data/';
        $profileImage = date('YmdHis') . "." . $image->getClientOriginalExtension();
        $image->move($destinationPath, $profileImage);
          
        $data = json_decode(file_get_contents($destinationPath . $profileImage), true);

        // for($i=0; $i<count($data['posts']); $i++) {
        //     // $exitComment = Comment::where('id',$data['comments'][$i]['id'])->first();
        //     // if(!$exitComment) {
        //         $new_comment = new Post();
        //         $new_comment->userId = $data['posts'][$i]['userId'];
        //         $new_comment->title = $data['posts'][$i]['title'];
        //         $new_comment->body = $data['posts'][$i]['body'];
        //         $new_comment->save();
        //     // }
            
        // }
        
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

                $exitUser = User::where('id',$data['comments'][$i]['user']['id'])->first();

                if(!$exitUser) {
                    $new_user = new User();
                    $new_user->id = $data['comments'][$i]['user']['id'];
                    $new_user->username = $data['comments'][$i]['user']['username'];
                    $new_user->save();
                }else {
                    $exitUser->username = $data['comments'][$i]['user']['username'];
                    $exitUser->save(); 
                }
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
        $request->session()->flash('success', 'Comments has been uploaded successfully!');
        return back();
    }
}
