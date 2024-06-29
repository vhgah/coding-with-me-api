<?php

namespace App\Http\Controllers\Admin;

use App\Models\File;
use App\Actions\CreateFile;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CreateFileRequest;
use App\RepositoryInterfaces\FileRepositoryInterface;

class FileController extends Controller
{
    public function __construct(
        protected FileRepositoryInterface $fileRepository
    ) {
        //
    }

    public function index(Request $request)
    {
        $options = [
            'type' => $request->input('type'),
            'sort_field' => 'created_at',
            'sort_order' => 'desc'
        ];

        $files = $this->fileRepository
            ->paginate($options)
            ->through(function (File $file) {
                return $this->getResource($file);
            });

        return response()->json($files);
    }

    public function store(CreateFileRequest $request)
    {
        $file = $request->file('file');

        $type = $request->input('type');

        $path = $file->store('files/' . $type, 'public');

        if ($path === false) {
            return response()->json([
                'message' => 'Failed to store file',
            ], 500);
        }

        $data = [
            'path' => $path,
            'name' => $file->getClientOriginalName(),
            'mime_type' => $file->getClientMimeType(),
            'size' => $file->getSize(),
            'type' => $type,
        ];

        $fileModel = CreateFile::make($data)->execute();

        return response()->json(
            $this->getResource($fileModel),
            201
        );
    }

    private function getResource(File $file)
    {
        return [
            'id' => $file->id,
            'url' => $file->getUrl(),
            'name' => $file->name,
            'mime_type' => $file->mime_type,
            'size' => $file->size,
            'type' => $file->type,
        ];
    }
}
