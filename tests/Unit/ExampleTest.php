<?php

namespace Tests\Unit;

//use PHPUnit\Framework\TestCase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_example()
    {
        $this->call('GET','/', [
            
                "key" => "templafnvbnbvte2",
                "delayed_send" => "22",
                "email" => [
                "jansamek2icewarcom"
                ],
                "bcc" => [
                "jansamek2icewarpcom"
                ],
                "body_data" => [
                "id" => "ABC-2022-XGF",
                "date" => "20223313122-12-24",
                "link" => [
                "label" => "icew544>/\]arp.com",
                "url" => "Go to asdfasour site"
                ]
                ]
        ]);
        $this->call('POST','/', [
            
            "key" => "templafnvbnbvte2",
            "delayed_send" => "22",
            "email" => [
            "jansamek2icewarcom"
            ],
            "bcc" => [
            "jansamek2icewarpcom"
            ],
            "body_data" => [
            "id" => "ABC-2022-XGF",
            "date" => "20223313122-12-24",
            "link" => [
            "label" => "icew544>/\]arp.com",
            "url" => "Go to asdfasour site"
            ]
            ]
    ]);
        $this->assertTrue(true);
    }
}
