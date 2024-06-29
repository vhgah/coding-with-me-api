<?php

namespace App\Actions;

use App\Models\File;

class CreateFile
{
    public function __construct(
        private array $data
    ) {
    }

    public function execute(): File
    {
        $file = File::create([
            'path' => $this->data['path'],
            'name' => $this->data['name'],
            'mime_type' => $this->data['mime_type'],
            'size' => $this->data['size'],
            'type' => $this->data['type'],
        ]);

        return $file;
    }

    public static function make(array $data): self
    {
        return new self($data);
    }
}
