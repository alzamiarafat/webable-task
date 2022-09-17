<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;


class PostController extends Controller
{
    public function index()
    {
        return view('posts');
    }

    public function details(Request $request)
    {
        $posts = Post::paginate(20);
        if($request->keyword != ''){
            $posts = Post::where('body','LIKE','%'.$request->keyword.'%')->paginate(20);
        }

        return response()->json([
            'posts' => $posts
        ]);
    }

    public function store(Request $request)
    {
        $image = $request->file('json_data');
        $destinationPath = 'data/';
        $profileImage = date('YmdHis') . "." . $image->getClientOriginalExtension();
        $image->move($destinationPath, $profileImage);
          
        $data = json_decode(file_get_contents($destinationPath . $profileImage), true);

        for($i=0; $i<count($data['posts']); $i++) {
            // $exitComment = Comment::where('id',$data['comments'][$i]['id'])->first();
            // if(!$exitComment) {
                $new_post = new Post();
                $new_post->userId = $data['posts'][$i]['userId'];
                $new_post->title = $data['posts'][$i]['title'];
                $new_post->body = $data['posts'][$i]['body'];
                $new_post->save();
            // }
            
        }
        
        $request->session()->flash('success', 'Posts has been uploaded successfully!');
        return back();
    }
}
