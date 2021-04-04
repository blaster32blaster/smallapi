<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\PostCreateRequest;
use App\Http\Requests\PostUpdateRequest;
use App\Models\Post;
use App\Services\PostService;

/**
 * handle post routing
 */
class PostController extends Controller
{
    /**
     *  a PostService instance
     *
     * @var PostService $postService
     */
    private $postService;

    public function __construct(PostService $postService)
    {
        $this->middleware('check.jwt')->only('update', 'store', 'destroy');
        $this->postService = $postService;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->postService->index();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\PostCreateRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PostCreateRequest $request)
    {
        return $this->postService->store($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        return $this->postService->show($post);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\PostUpdateRequest  $request
     * @param  int  $post
     * @return \Illuminate\Http\Response
     */
    public function update(PostUpdateRequest $request, Post $post)
    {
        return $this->postService->update($post, $request);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        return $this->postService->destroy($post);
    }
}
