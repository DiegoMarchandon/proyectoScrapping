<?php

namespace App\Tests;

use PHPUnit\Framework\TestCase;
use App\HolaMundo;

class HolaMundoTest extends TestCase {
    public function testDiceHolaMundo(){
        $holaMundo = new HolaMundo();
        $this->assertEquals('Hola mundo!',$holaMundo->saluda());
    }
}