<?php

namespace App\Tests;

use PHPUnit\Framework\TestCase;
use App\TransactionsComissionRefactor;

class RefactorTest extends TestCase
{
    public function testTransactionComissions(): void
    {
        $expectedResults = [1.0,0.47,1.26,2.46,46.12];

        $data = array_map(function ($row){
            return json_decode($row);
        }, explode("\n", file_get_contents(__DIR__ . '/input.txt')));

        $comission = new TransactionsComissionRefactor($data);
        $comissions = array_column($comission->rates(),'eurComission');

        // dump($comission->rates());

        foreach ($comissions as $key => $comission) {
            $this->assertEquals($expectedResults[$key], $comission);
        }

    }
}
