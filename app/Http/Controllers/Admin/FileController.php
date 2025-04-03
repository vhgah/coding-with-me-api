<?php

namespace App\Http\Controllers\Admin;

use App\Models\File;
use App\Actions\UploadFileToDiscord;
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

        $data = $request->only('type');

        $result = UploadFileToDiscord::make($file, [
            'type' => $data['type']
        ])->execute();

        return response()->json(
            $this->getResource($result),
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
