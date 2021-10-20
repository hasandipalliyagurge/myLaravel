<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class HomeTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testHomePageIsWorkingCorrectly()
    {
        $response = $this->get('/');

        $response->assertSeeText('Hello World');
    }

    public function testContactPageIsWorkingCorrectly(){

        $response = $this->get('/contacts');
        $response->assertSeeText('Contacts');
        $response->assertSeeText('Hello this is contacts page');
    }
}
