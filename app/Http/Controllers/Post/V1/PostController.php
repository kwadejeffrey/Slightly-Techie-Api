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
    /**
     * Get all post
     * @apiResourceModel App\Models\Post
     * @apiResource App\Http\Resources\V1\PostResource
     * 
     * @return PostResource
     */
    public function index()
    {
        
        return PostResource::collection(Post::query()->latest()->get());
       
    }

    /**
     * Create new blog post
     * 
     * @apiResource App\Http\Resources\V1\PostResource
     * @apiResourceModel App\Models\Post
     * 
     * @return PostResource
     */
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

    /**
     * Display blog post
     * 
     * @apiResource App\Http\Resources\V1\PostResource
     * @apiResourceModel App\Http\Models\Post
     */
    public function show(Post $post)
    {
        return new PostResource($post);
    }

    /**
     * Fetch blog post belonging to user
     * 
     * @apiResource App\Http\Resources\V1\PostResource
     * 
     * @apiResourceModel App\Http\Models\Post
     * 
     * @return PostResource
     */
    public function myPosts()
    {
        $post = Post::query()->latest()->where('user_id',auth()->id())->get();
        // dd($post);
        return PostResource::collection($post);
    }


    /**
     * Update blog post
     * 
     * @bodyParam title string required
     * @bodyParam sub_heading string required
     * @bodyParam blog string required
     * @bodyParam user_id int required
     * 
     * @apiResourceModel App\Http\Models\Post
     * @apiResource App\Http\Resources\V1\PostResource
     * 
     * @return PostResource
     */
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

    /**
     * Delete blog post
     * 
     * @apiResourceModel App\Http\Models\Post
     * 
     * @return JsonResponse
     */
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
