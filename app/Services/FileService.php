<?php

namespace App\Services;

use App\Http\Requests\FileCreateRequest;
use App\Models\File;
use Illuminate\Http\Response;

/**
 * handle file actions
 */
class FileService
{
    /**
     * fetch a single record
     *
     * @param File $file
     * @return Response
     */
    public function show(File $file) : Response
    {
        return response($file);
    }

    /**
     * fetch all records
     *
     * @return Response
     */
    public function index() : Response
    {
        return response(File::all());
    }

    /**
     * store a new record
     *
     * @param FileCreateRequest $request
     * @return Response
     */
    public function store(FileCreateRequest $request) : Response
    {
        $file = new File;
        $file->fill($request->all());
        return response($file->save());
    }

    /**
     * delete a record
     *
     * @param File $file
     * @return Response
     */
    public function destroy(File $file) : Response
    {
        return response($file->delete());
    }
}
