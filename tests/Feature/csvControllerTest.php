<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Http\UploadedFile;

class csvControllerTest extends TestCase
{

    /** @test */
      public function checkStatusWithoutFile()
    {
        $response = $this->post('api/csv');

        $response->assertStatus(422);
    }

    /** @test */
  // test for content and proper response
     public function uploadFakeData()
    {
   
    $header = 'name,age';
    $row1 = 'sean,2';
    $row2 = 'john,2';
    $row3 = 'Tim,3';
    $row4 = 'Ben,25';
    $row5 = 'Hanna,80';
    $row6 = 'bob,40';
    $row7 = 'joe,40';
    $row8 = 'Ellen,24';
    $row9 = 'Teck,24';
    $row10 = 'Micheal,2';

    $content = implode("\n", [$header, $row1, $row2, $row3, $row4, $row5, $row6, $row7, $row8, $row9, $row10]);

    $input = [
        'file' =>
            UploadedFile::
                fake()->
                createWithContent(
                    'test.csv',
                    $content
                )
    ];


//check responce and expected result 
$response = $this->postJson('api/csv', $input)->assertStatus(201);

$response
        ->assertStatus(201)
        ->assertJsonFragment([
            'age' => 2,
            'dups' => 3,
            'percentage' => 30
        ]);
    }
}
