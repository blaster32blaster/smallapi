<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\FileCreateRequest;
use App\Models\File;
use App\Services\FileService;

/**
 * handle file routing
 */
class FileController extends Controller
{
    /**
     * a FileService instance
     *
     * @var FileService $fileService
     */
    private $fileService;

    public function __construct(FileService $fileService)
    {
        $this->middleware('check.jwt')->only('store', 'destroy');
        $this->fileService = $fileService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->fileService->index();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\FileCreateRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(FileCreateRequest $request)
    {
        return $this->fileService->store($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $file
     * @return \Illuminate\Http\Response
     */
    public function show(File $file)
    {
        return $this->fileService->show($file);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $file
     * @return \Illuminate\Http\Response
     */
    public function destroy(File $file)
    {
        return $this->fileService->destroy($file);
    }
}
