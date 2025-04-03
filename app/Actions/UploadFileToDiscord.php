<?php

namespace App\Actions;

use App\Enums\FileTypeEnum;
use App\Models\File;
use Exception;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Http;

class UploadFileToDiscord
{
    public function __construct(
        private UploadedFile $file,
        private array $options = []
    ) {
        //
    }

    public function execute(): File
    {
        $file = $this->file;

        if (!$file->isValid()) {
            throw new \Exception('Invalid file upload.');
        }

        $fileName = $file->getClientOriginalName();
        $discordUrl = config('upload.discord.image.url');

        $response = Http::attach(
            'file',
            file_get_contents($file->getRealPath()),
            $fileName,
        )->post($discordUrl);

        if (!$response->successful()) {
            throw new \Exception('Upload failed: ' . $response->body());
        }

        $imageUrl = $response->json('attachments.0.url');

        if (!$imageUrl) {
            throw new Exception('Failed to retrieve image URL.');
        }

        return CreateFile::make([
            'path' => $imageUrl,
            'name' => $fileName,
            'mime_type' => $file->getClientMimeType(),
            'size' => $file->getSize(),
            'type' => $this->options['type'] ?? FileTypeEnum::SYSTEM,
        ])->execute();
    }

    public static function make(UploadedFile $file, array $options = []): self
    {
        return new static($file, $options);
    }
}
