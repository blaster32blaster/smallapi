<?php

namespace App\Services;

use App\Http\Requests\TagCreateRequest;
use App\Http\Requests\TagUpdateRequest;
use App\Models\Tag;
use Illuminate\Http\Response;

/**
 * handle tag actions
 */
class TagService
{
    /**
     * fetch a single record
     *
     * @param Tag $tag
     * @return Response
     */
    public function show(Tag $tag) : Response
    {
        return response($tag);
    }

    /**
     * fetch all records
     *
     * @return Response
     */
    public function index() : Response
    {
        return response(Tag::all());
    }

    /**
     * store a new record
     *
     * @param TagCreateRequest $request
     * @return Response
     */
    public function store(TagCreateRequest $request) : Response
    {
        return response($this->createTag($request->all()));
    }

    /**
     * create a tag in DB
     *
     * @param array $values
     * @return Tag
     */
    public function createTag(array $values) : Tag
    {
        $tag = new Tag;
        $tag->fill($values);
        $tag->save();
        return $tag;
    }

    /**
     * delete a record
     *
     * @param Tag $tag
     * @return Response
     */
    public function destroy(Tag $tag) : Response
    {
        return response($tag->delete());
    }

    /**
     * update an existing record
     *
     * @param Tag $tag
     * @param TagUpdateRequest $request
     * @return Response
     */
    public function update(Tag $tag, TagUpdateRequest $request) : Response
    {
        $tag->fill($request->all());
        return response($tag->save());
    }
}
