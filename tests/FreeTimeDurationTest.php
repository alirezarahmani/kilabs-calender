<?php

namespace App\Tests;

use App\Domain\Model\FreeTimeDuration;
use App\Domain\Model\HourlyTimeFormat;
use PHPUnit\Framework\TestCase;

class FreeTimeDurationTest extends TestCase
{
    /** @test */
    public function should_set_right_date()
    {
        $object = new FreeTimeDuration(new HourlyTimeFormat(), '2019-09-01', '19:00:00');
        $this->assertEquals($object->getDate(), new \DateTime('2019-09-01 19:00:00'));
    }

    /** @test */
    public function should_set_right_to_date()
    {
        $object = new FreeTimeDuration(new HourlyTimeFormat(), '2019-09-01', '19:00:00','19:00:00','2020-09-01');
        $this->assertEquals($object->getDate(), new \DateTime('2019-09-01 19:00:00'));
    }
}
