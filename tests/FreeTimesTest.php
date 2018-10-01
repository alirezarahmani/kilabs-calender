<?php

namespace App\Tests;

use App\Domain\Entity\UserEntity;
use App\Domain\Model\CandidateFreeTimes;
use App\Domain\Model\FreeTimeDuration;
use App\Domain\Model\InterviewerFreeTimes;
use App\Infrastructure\Repository\TimeSheetRepository;
use InvalidArgumentException;
use Mockery;
use PHPUnit\Framework\TestCase;

class FreeTimesTest extends TestCase
{
    private $repository;

    /** @var FreeTimeDuration */
    private $duration;

    public function setUp()
    {
        $this->repository = Mockery::mock(TimeSheetRepository::class);
        $this->duration = Mockery::mock(FreeTimeDuration::class);
    }

    public function tearDown()
    {
        Mockery::close();
    }

    /** @test */
    public function should_throw_exception_with_already_candidate_exist()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('the requested time slot is already exist');
        $this->repository->shouldReceive('findOneBy')->andReturn(['sample' =>'sample']);
        $this->duration->shouldReceive('getDate')->andReturn('2010-09-01');
        $this->duration->shouldReceive('getToDate')->andReturn(null);
        (new CandidateFreeTimes())->apply(\Mockery::mock(UserEntity::class), $this->duration, $this->repository);
    }

    /** @test */
    public function should_throw_exception_with_already_interviewer_exist()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('the requested time slot is already exist');
        $this->repository->shouldReceive('findOneBy')->andReturn(['sample' =>'sample']);
        $this->duration->shouldReceive('getDate')->andReturn('2010-09-01');
        $this->duration->shouldReceive('getToDate')->andReturn(null);
        (new InterviewerFreeTimes())->apply(\Mockery::mock(UserEntity::class), $this->duration, $this->repository);
    }
}
