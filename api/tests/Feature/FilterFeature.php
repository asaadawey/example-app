<?php

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
class FilterFeature extends TestCase
{
    public function testSuccessResponse()
    {
        $response = $this->call(
            'POST',
            '/get_images',
            [],
            [],
            [],
            [],
            '{
                "filter": {
                    "name": {
                        "end_with": "it"
                    }
                }
            }'
        );
        $response->assertStatus(200);

    }
    public function testWrongArgsResponse()
    {
        $response = $this->call(
            'POST',
            '/get_images',
            [],
            [],
            [],
            [],
            '{
                "filter": {
                    "namesssss": {
                        "end_with": "it"
                    }
                }
            }'
        );
        $response->assertStatus(400);

    }
}
