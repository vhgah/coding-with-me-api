<?php

namespace App\Enums;

class FileTypeEnum
{
    const POST = 'post';
    const BLOG = 'blog';
    const SYSTEM = 'system';

    public static function getValues(): array
    {
        return [
            self::POST,
            self::BLOG,
            self::SYSTEM,
        ];
    }
}
