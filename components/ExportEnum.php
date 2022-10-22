<?php

namespace app\components;

class ExportEnum
{
    public const JSON = 'json';
    public const CSV = 'csv';

    public static function enum() {
        return [
            self::JSON,
            self::CSV
        ];
    }
}
