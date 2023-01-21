<?php

namespace App\Http\Controllers;

use App\enums\FileSourceTypeEnum;
use App\Http\Requests\DestroyFileSourceRequest;
use App\Http\Requests\StoreFileSourceRequest;
use App\Http\Requests\UpdateFileSourceRequest;
use App\Http\Resources\FileSourceResource;
use App\Jobs\ParseFileJob;
use App\Models\FileSource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FileSourceController extends Controller
{

    public function index(Request $request)
    {
        return $request->user()->fileSources;
    }

    public function show(FileSource $fileSource): FileSourceResource
    {
        return new FileSourceResource($fileSource);
    }

    public function store(StoreFileSourceRequest $request): FileSourceResource
    {
        DB::beginTransaction();
        try {
            $fileSource = $request->user()->fileSources()->create($request->all());
            if ($fileSource->type == FileSourceTypeEnum::URL) {
                $fileSource
                    ->addMediaFromUrl($fileSource->path)
                    ->toMediaCollection('file');
            }
            DB::commit();

            return new FileSourceResource($fileSource);
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function storeFile()
    {

    }

    public function update(UpdateFileSourceRequest $request, FileSource $fileSource): FileSourceResource
    {
        $fileSource->update($request->all());
        return new FileSourceResource($fileSource);
    }

    public function destroy(FileSource $fileSource, DestroyFileSourceRequest $request)
    {
        $fileSource->delete();
        return response(null, 204);
    }
}
