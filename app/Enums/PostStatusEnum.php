<?php

namespace App\Enums;

class PostStatusEnum
{
    const ACTIVE = 1;
    const INACTIVE = 2;
    const DRAFT = 3;

    public static function getValues(): array
    {
        return [
            self::ACTIVE,
            self::INACTIVE,
            self::DRAFT,
        ];
    }
}
