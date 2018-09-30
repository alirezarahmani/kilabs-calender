<?php

namespace App\Tests;

use App\Infrastructure\Response\ApiJsonResponse;
use PHPUnit\Framework\TestCase;

class ApiJsonResponseTest extends TestCase
{
    private $apiJson;

    public function setUp()
    {
        $this->apiJson = new ApiJsonResponse();
    }

    /** @test */
    public function should_work_with_simple_string_message()
    {
        $this->apiJson->error('hi');
        $this->expectOutputString('{"Data":[],"Status":false,"Message":"hi"}');
    }

    /** @test */
    public function should_work_with_simple_json_message()
    {
        $this->apiJson->error(json_encode(['hi' => 'guys']));
        $this->expectOutputString('{"Data":[],"Status":false,"Message":{"hi":"guys"}}');
    }
}
