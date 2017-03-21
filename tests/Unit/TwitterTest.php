<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use TwitterSearch\Twitter;

/**
 * Defining an example of a positive Twitter responseh
 */
class PositiveResponse
{
	protected $body;

	public function __construct()
	{
		$this->body = new \StdClass();
		$this->body->statuses = ['Tweet', 'Tweet', 'Tweet'];	
	}

	public function getStatusCode()
	{
		return 200;
	}

	public function getBody()
	{
		return json_encode($this->body);
	}
}

class TwitterTest extends TestCase
{
	protected function tearDown() 
	{
		\Mockery::close();
	}

	function testTwitterSendsPositiveResponse() 
	{
        //$failed_authentication_response = new \Exception('Missing queries');

		$succesfull_response = new PositiveResponse();

		$mock_client = \Mockery::mock('HttpClient');
		$mock_client->shouldReceive('request')->andReturn($succesfull_response);

		$twitter = new Twitter($mock_client, 'dummykey','dummykey');
		// Make the request with the mocked class
		$twitter->makeRequest('London', 10);

		// Check if our Twitter class handled the code properly, by storing the status code
		$this->assertEquals(200, $twitter->getStatusCode());
	}

	function testTwitterSendsExceptionResponse() 
	{
        $failed_authentication_response = new \Exception('Something went wrong');		// Any missing argument, bad authentication ...

        $mock_client = \Mockery::mock('HttpClient');
        $mock_client->shouldReceive('request')->andThrow('\Exception', 'Something went wrong');

        $twitter = new Twitter($mock_client, 'dummykey','dummykey');
		// Make the request with the mocked class
        $twitter->makeRequest('London', 10);

        $this->assertSame($failed_authentication_response->getMessage(), $twitter->getResponse());
    }
}
