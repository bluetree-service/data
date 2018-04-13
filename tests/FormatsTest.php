<?php

namespace Test;

use BlueData\Data\Formats;
use PHPUnit\Framework\TestCase;

class FormatsTest extends TestCase
{
    public function testByteSizeFormat()
    {
        $bytes = 100;
        $kiloBytes = 1200;
        $megaBytes = 1200000;
        $gigaBytes = 1200000000;
        $terraBytes = 1200000000000;
        $petaBytes = 1200000000000000;

        $this->assertEquals('100.00 B', Formats::dataSize($bytes));
        $this->assertEquals('1.20 kB', Formats::dataSize($kiloBytes));
        $this->assertEquals('1.20 MB', Formats::dataSize($megaBytes));
        $this->assertEquals('1.20 GB', Formats::dataSize($gigaBytes));
        $this->assertEquals('1.20 TB', Formats::dataSize($terraBytes));
        $this->assertEquals('1.20 PB', Formats::dataSize($petaBytes));
    }
}
