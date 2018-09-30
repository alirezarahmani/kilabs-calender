<?php

namespace App\Tests;

use App\Infrastructure\Validator\FreeTimeApiValidator;
use PHPUnit\Framework\TestCase;

class FreeTimeApiValidatorTest extends TestCase
{
    /** @var FreeTimeApiValidator */
    private $validator;

    public function setUp()
    {
        $this->validator = new FreeTimeApiValidator();
    }

    /** @test */
    public function should_throw_exception_with_empty_array()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('["\"hour\"This field is missing.","\"date\"This field is missing.","\"id\"This field is missing.","\"userType\"This field is missing."]');
        $this->validator->validate([]);
    }

    /** @test */
    public function should_throw_exception_with_missing_date()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('["\"date\"This field is missing."]');
        $this->validator->validate(['id' => 1, 'hour' => '12:00:00', 'userType' => 'candidate']);
    }

    /** @test */
    public function should_throw_exception_with_missing_id()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('["\"id\"This field is missing."]');
        $this->validator->validate(['date' => '2018-08-01', 'hour' => '12:00:00', 'userType' => 'candidate']);
    }

    /** @test */
    public function should_throw_exception_with_missing_user_type()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('["\"userType\"This field is missing."]');
        $this->validator->validate(['date' => '2018-08-01', 'hour' => '12:00:00', 'id' => 1]);
    }

    /** @test */
    public function should_throw_exception_with_wrong_date()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('["\"201\"This value is not a valid date."]');
        $this->validator->validate(['date' => '201' ,'id' => 1, 'hour' => '12:00:00', 'userType' => 'candidate']);
    }

    /** @test */
    public function should_throw_exception_with_missing_hour()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('["\"hour\"This field is missing."]');
        $this->validator->validate(['date' => '2010-09-01' ,'id' => 1, 'userType' => 'candidate']);
    }

    /** @test */
    public function should_throw_exception_with_wrong_hour()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('["\"120:00\"This value is not a valid time."]');
        $this->validator->validate(['date' => '2010-09-01', 'hour' => '120:00','id' => 1, 'userType' => 'candidate']);
    }

    /** @test */
    public function should_throw_exception_with_wrong_to_hour()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('["\"130:00\"This value is not a valid time."]');
        $this->validator->validate(['date' => '2010-09-01', 'hour' => '12:00:00', 'toHour' => '130:00','id' => 1, 'userType' => 'candidate']);
    }

    /** @test */
    public function should_throw_exception_with_wrong_to_date()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('["\"2016\"This value is not a valid date."]');
        $this->validator->validate(['date' => '2010-09-01', 'hour' => '12:00:00', 'toDate' => '2016','toHour' => '13:00:00','id' => 1, 'userType' => 'candidate']);
    }

    /** @test */
    public function should_throw_exception_with_smaller_to_date()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('["\"2000-01-10\"\"2010-09-01\"stringThis value should be greater than \"2010-09-01\"."]');
        $this->validator->validate(['date' => '2010-09-01', 'hour' => '12:00:00', 'toDate' => '2000-01-10','toHour' => '13:00:00','id' => 1, 'userType' => 'candidate']);
    }

    /** @test */
    public function should_throw_exception_with_smaller_to_hour()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('["please make sure toHour is greater than hour"]');
        $this->validator->validate(['date' => '2010-09-01', 'hour' => '14:00:00', 'toHour' => '10:00:00','id' => 1, 'userType' => 'candidate']);
    }

    /** @test */
    public function should_throw_exception_with_equal_to_hour()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('["please make sure toHour is greater than hour"]');
        $this->validator->validate(['date' => '2010-09-01', 'hour' => '14:00:00', 'toHour' => '10:00:00','id' => 1, 'userType' => 'candidate']);
    }

    /** @test */
    public function should_throw_exception_with_equal_to_date()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('["\"2010-09-01\"\"2010-09-01\"stringThis value should be greater than \"2010-09-01\".","\"2010-09-01\"\"2010-09-01\"stringThis value should not be equal to \"2010-09-01\"."]');
        $this->validator->validate(['date' => '2010-09-01', 'hour' => '12:00:00', 'toDate' => '2010-09-01','toHour' => '13:00:00','id' => 1, 'userType' => 'candidate']);
    }

    /** @test */
    public function should_not_throw_exception_with_right_values()
    {
        $this->validator->validate(['date' => '2019-10-01', 'hour' => '12:00:00', 'toDate' => '2019-12-01','toHour' => '13:00:00','id' => 1, 'userType' => 'candidate']);
        $this->assertTrue(true);
    }
}
