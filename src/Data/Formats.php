<?php

declare(strict_types=1);

namespace BlueData\Data;

class Formats
{
    public const SIZE_UNITS = ['B', 'kB', 'MB', 'GB', 'TB', 'PB'];

    /**
     * @param int $bytes
     * @return string
     */
    public static function dataSize(int $bytes): string
    {
        $format = '%01.2f %s';
        $mod = 1000;
        $power = ($bytes > 0) ? \floor(\log($bytes, $mod)) : 0;

        return \sprintf($format, $bytes / ($mod ** $power), self::SIZE_UNITS[$power]);
    }
}
