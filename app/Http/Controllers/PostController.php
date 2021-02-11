<?php

namespace App\Http\Controllers;

use App\Models\Like;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class PostController extends Controller
{
    public function index(){
        $posts = Post::orderBy('created_at','desc')->get();

        return view('home',[
            'posts' => $posts
        ]);
    }

    public function store(){

        request()->validate([
            'post' => 'required|max: 1000',
        ]);
        
        $post = Post::create([
            'body' => request('post'),
            'user_id' => Auth::user()->id
        ]);

        if($post){
            // $message = "Post created successfully!";
            return redirect('/')->with([
                'status' => 'Post created successfully!',
                'alert-type' => 'success',
            ]);
        }
        else
        {
            return redirect('/')->with([
                'status' => 'There was an error.',
                'alert-type' => 'danger',
            ]);
        }

        // if(Auth::check()){
        //     request()->validate([
        //         'body' => 'required|max: 1000',
        //     ]);
    
        //     $post = Post::create([
        //         'body' => request('body'),
        //         'user_id' => Auth::user()->id
        //     ]);
        //     return response()->json([
        //         'post-body' => $post->body,
        //         'user' => $post->user->name,
        //         'post-created-at' => $post->created_at,
        //     ]);
        // }
        // else{
        //     abort(401, 'You need to login again.');
        // }
        
    }

    public function destroy(Post $post){

        if($post){
            if(Auth::user() != $post->user){
                return redirect()->back();
            }
            $post->delete();
            return redirect('/')->with([
                'status' => 'Post deleted successfully.',
                'alert-type' => 'success',
            ]);
        }
        else{
            return redirect('/')->with([
                'status' => 'Post deleted failed.',
                'alert-type' => 'danger',
            ]);
        }
    }

    public function update(Post $post)
    {
        request()->validate([
            'body' => 'required|max: 1000',
        ]);
        // $post = Post::find(request('postId'));
        if(Auth::user() != $post->user){
            return redirect()->back();
        }
        $post->body = request('body');
        $post->save();

        return response()->json(['new_body' => $post->body], 200);
    }

    public function like(Post $post)
    {
        //transform from string to boolean
        $isLike = request('isLike') === 'true';
        
        $user = Auth::user();

        $like = $user->likes->where('post_id', $post->id)->first();

        if($like){
            if($like->like == $isLike){
                $like->delete();
                // return null;
            }
            else{
                $like->like = $isLike;
                $like->save();
            }
        }
        else{
            $like = Like::create([
                'user_id' => $user->id,
                'post_id' => $post->id,
                'like' => $isLike
            ]);
        }
        $likeCount = $post->likes->where('like',1)->count();
        $dislikeCount = $post->likes->where('like',0)->count();

        return response()->json([
            'likeCount' => $likeCount,
            'dislikeCount' => $dislikeCount
        ], 200);
    }

    public function validation(){
        request()->validate([
            'post' => 'required|max: 1000',
        ]);
    }
}
