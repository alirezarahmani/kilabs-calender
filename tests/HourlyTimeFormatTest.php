<?php

namespace App\Tests;

use App\Domain\Model\HourlyTimeFormat;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class HourlyTimeFormatTest extends TestCase
{
    /** @var HourlyTimeFormat */
    private $hourlyTime;

    public function setUp()
    {
        $this->hourlyTime = new HourlyTimeFormat();
    }

    /** @test */
    public function should_throw_exception_with_wrong_time()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('wrong hourly timeSlot, please make sure you select 11:00:00 like format');
        $this->hourlyTime->setTime(new \DateTime(), '12:00:0');
    }

    /** @test */
    public function should_not_be_same()
    {
        $dateNow = new \DateTime('2019-09-09 08:00:00');
        $dateTime = $this->hourlyTime->setTime(new \DateTime(), '12:00:00');
        $this->assertNotEquals($dateTime, $dateNow);
    }

    /** @test */
    public function should_be_same()
    {
        $dateNow = new \DateTime('2019-09-09 10:00:00');
        $dateTime = $this->hourlyTime->setTime(new \DateTime('2019-09-09 08:00:00'), '10:00:00');
        $this->assertEquals($dateTime, $dateNow);
    }
}
