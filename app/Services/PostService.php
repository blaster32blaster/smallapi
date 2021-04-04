<?php

namespace App\Services;

use App\Http\Requests\PostCreateRequest;
use App\Http\Requests\PostUpdateRequest;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

/**
 * handle post actions
 */
class PostService
{
    /**
     * a TagService instance
     *
     * @var TagService $tagService
     */
    private $tagService;

    public function __construct(TagService $tagService)
    {
        $this->tagService = $tagService;
    }

    /**
     * fetch a single record
     *
     * @param Post $post
     * @return Response
     */
    public function show(Post $post) : Response
    {
        return response($post);
    }

    /**
     * fetch all records
     *
     * @return Response
     */
    public function index() : Response
    {
        return response(Post::all());
    }

    /**
     * store a new record
     *
     * @param PostCreateRequest $request
     * @return Response
     */
    public function store(PostCreateRequest $request) : Response
    {
        $post = new Post;
        $post->id = $request->get('id');
        $post->title = $request->get('title');
        $post->body = $request->get('body');
        $post->owner = $this->setPostOwner($post, $request);
        $post->main_image = $this->setPostFile($post, $request);
        $response = $post->save();

        foreach ($request->get('tags') as $tag) {
            $tagSaved = $this->tagService->createTag($tag);
            $post->tags()->attach($tagSaved->id);
        }

        return response($response);
    }

    /**
     * delete a record
     *
     * @param Post $tag
     * @return Response
     */
    public function destroy(Post $post) : Response
    {
        return response($post->delete());
    }

    /**
     * update an existing record
     *
     * @param Post $post
     * @param PostUpdateRequest $request
     * @return Response
     */
    public function update(Post $post, PostUpdateRequest $request) : Response
    {
        $post->id = $request->get('id') ?? $post->id;
        $post->title = $request->get('title') ?? $post->title;
        $post->body = $request->get('body') ?? $post->body;
        $post->owner
            = null !== $request->get('owner') ? $this->setPostOwner($post, $request) : $post->owner;
        $post->main_image
            = null !== $request->get('main_image') ? $this->setPostFile($post, $request) : $post->main_image;
        $response = $post->save();

        $tags = $post->tags;
        foreach ($tags as $tag) {
            $this->removePostTags($tag, $post);
        }

        if ($request->get('tags') && count($request->get('tags')) > 0) {
            foreach ($request->get('tags') as $tag) {
                $tagSaved = $this->tagService->createTag($tag);
                $post->tags()->attach($tagSaved->id);
            }
        }

        return response($response);
    }

    /**
     * detach and delete tags from posts
     *
     * @param Tag $tag
     * @param Post $post
     * @return void
     */
    private function removePostTags(Tag $tag, Post $post) : void
    {
        $count = Tag::whereHas('posts', function ($q) use ($tag) {
            $q->where('tag_id', '=', $tag->id);
        })->count();

        $post->tags()->detach($tag->id);
        if ($count === 1) {
            $this->tagService->destroy($tag);
        }
    }

    /**
     * get the id for the post owner
     *
     * @param Post $post
     * @param Request $request
     * @return integer
     */
    private function setPostOwner(Post $post, Request $request) : int
    {
        $ownerInit = $request->get('owner');
        if (is_string($ownerInit) || is_integer($ownerInit)) {
            return $ownerInit;
        }

        return $ownerInit['id'];
    }

    /**
     * get the file id
     *
     * @param Post $post
     * @param Request $request
     * @return integer
     */
    private function setPostFile(Post $post, Request $request) : int
    {
        $fileInit = $request->get('main_image');
        if (is_string($fileInit) || is_integer($fileInit)) {
            return $fileInit;
        }

        return $fileInit['id'];
    }
}
