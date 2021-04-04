<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\TagCreateRequest;
use App\Http\Requests\TagUpdateRequest;
use App\Models\Tag;
use App\Services\TagService;
use Illuminate\Http\Request;

/**
 * handle tag routing
 */
class TagController extends Controller
{
    /**
     * a TagService instance
     *
     * @var TagService $tagService
     */
    private $tagService;

    public function __construct(TagService $tagService)
    {
        $this->middleware('check.jwt')->only('update', 'store', 'destroy');
        $this->tagService = $tagService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->tagService->index();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TagCreateRequest $request)
    {
        return $this->tagService->store($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $tag
     * @return \Illuminate\Http\Response
     */
    public function show(Tag $tag)
    {
        return $this->tagService->show($tag);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\TagUpdateRequest  $request
     * @param  int  $tag
     * @return \Illuminate\Http\Response
     */
    public function update(TagUpdateRequest $request, Tag $tag)
    {
        return $this->tagService->update($tag, $request);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $tag
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tag $tag)
    {
        return $this->tagService->destroy($tag);
    }
}
