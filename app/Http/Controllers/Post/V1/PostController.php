<?php

namespace App\Http\Controllers\Post\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Post\V1\StorePostRequest;
use App\Http\Resources\V1\PostResource;
use App\Models\Post;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    //
    public function index()
    {
        $post = Post::query()->latest()->get();
        return PostResource::collection(Post::query()->latest()->get());
        // return new JsonResponse([
        //     "posts" => Post::all()
        // ]);
    }

    public function store(StorePostRequest $request)
    {
        $data = [
            "title" => $request->title,
            "sub_heading" => $request->sub_heading,
            "blog" => $request->blog,
            "user_id" => auth()->id()
        ];

        if(Auth::check()){
            $post = Post::create($data);
        }

        return new PostResource($post);
    }

    public function show(Post $post)
    {
        return new PostResource($post);
    }

    public function myPosts()
    {
        $post = Post::query()->latest()->where('user_id',auth()->id())->get();
        // dd($post);
        return PostResource::collection($post);
    }

    public function update(Post $post, Request $request)
    {
        // dd($post);
        $data = [
            'title' => $request->title,
            'sub_heading' => $request->sub_heading,
            'blog' => $request->blog,
            'user_id' => auth()->id()
        ];
        if($post->user_id === auth()->id()){
            $post->update($data);
        }else{
            return new JsonResponse([
                "Failed" => "You do not have authorization to delete blog post"
            ]);
        }

        return new PostResource($post);
    }

    public function delete(Post $post)
    {
        if($post->user_id === auth()->id()){
            $post->delete();
            return new JsonResponse([
                "Success" => "Blog Post deleted"
            ]);
        }else{
            return new JsonResponse([
                "Failed" => "You do not have authorization to delete blog post"
            ]);
        }
    }
}
