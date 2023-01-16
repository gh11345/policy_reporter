<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Classes\ModuloThree;

class modThreeTest extends TestCase
{

    public function test_processingState()
    {
        $result = ModuloThree::processingState('S0', 1);
        $this->assertEquals($result, 'S1');

        $result = ModuloThree::processingState('S0', 0);
        $this->assertEquals($result, 'S0');

        $result = ModuloThree::processingState('S1', 1);
        $this->assertEquals($result, 'S0');

        $result = ModuloThree::processingState('S1', 0);
        $this->assertEquals($result, 'S2');

        $result = ModuloThree::processingState('S2', 1);
        $this->assertEquals($result, 'S2');

        $result = ModuloThree::processingState('S2', 0);
        $this->assertEquals($result, 'S1');

        $result = ModuloThree::processingState('S1', 2);
        $this->assertEquals($result, '');

        $result = ModuloThree::processingState('S1', 'A');
        $this->assertEquals($result, '');

    }

    public function test_processingMappedStates()
    {
        $transitionFunction = [
            ['S0', 0, 'S0'],
            ['S0', 1, 'S1'],
            ['S1', 0, 'S2'],
            ['S1', 1, 'S0'],
            ['S2', 0, 'S1'],
            ['S2', 1, 'S2']
        ];

        $result = ModuloThree::processingMappedStates($transitionFunction, 'S0', 0);
        $this->assertEquals($result, 'S0');

        $result = ModuloThree::processingMappedStates($transitionFunction, 'S0', 1);
        $this->assertEquals($result, 'S1');

        $result = ModuloThree::processingMappedStates($transitionFunction, 'S1', 1);
        $this->assertEquals($result, 'S0');

        $result = ModuloThree::processingMappedStates($transitionFunction, 'S1', 0);
        $this->assertEquals($result, 'S2');

        $result = ModuloThree::processingMappedStates($transitionFunction, 'S2', 1);
        $this->assertEquals($result, 'S2');

        $result = ModuloThree::processingMappedStates($transitionFunction, 'S2', 0);
        $this->assertEquals($result, 'S1');

        $result = ModuloThree::processingMappedStates($transitionFunction, 'S3', 0);
        $this->assertEquals($result, '');
    }


    public function test_modThreeCases1()
    {
        $modThreeCase1 = ModuloThree::modThree('110');
        $this->assertEquals($modThreeCase1, 0);

    }

    public function test_modThreeFaCases1()
    {
        $finiteSetOfStates = ['S0', 'S1', 'S2'];
        $inputArr =  ['1', '1', '0'];
        $initialState = 'S0';
        $acceptingStates = ['S0', 'S1', 'S2'];
        $transitionFunction = [
            ['S0', 0, 'S0'],
            ['S0', 1, 'S1'],
            ['S1', 0, 'S2'],
            ['S1', 1, 'S0'],
            ['S2', 0, 'S1'],
            ['S2', 1, 'S2']
        ];
        $modThreeCase1 = ModuloThree::ModThreeFA($finiteSetOfStates, $inputArr, $initialState,
            $acceptingStates, $transitionFunction);
        $this->assertEquals($modThreeCase1, 0);

    }

    public function test_modThreeCases2()
    {
        $modThreeCase1 = ModuloThree::modThree('1010');
        $this->assertEquals($modThreeCase1, 1);

    }

    public function test_modThreeFaCases2()
    {
        $finiteSetOfStates = ['S0', 'S1', 'S2'];
        $inputArr =  ['1', '0', '1', '0'];
        $initialState = 'S0';
        $acceptingStates = ['S0', 'S1', 'S2'];
        $transitionFunction = [
            ['S0', 0, 'S0'],
            ['S0', 1, 'S1'],
            ['S1', 0, 'S2'],
            ['S1', 1, 'S0'],
            ['S2', 0, 'S1'],
            ['S2', 1, 'S2']
        ];
        $modThreeCase1 = ModuloThree::ModThreeFA($finiteSetOfStates, $inputArr, $initialState,
            $acceptingStates, $transitionFunction);
        $this->assertEquals($modThreeCase1, 1);

    }

    public function test_modThreeCases3()
    {
        $modThreeCase1 = ModuloThree::modThree('10101');
        $this->assertEquals($modThreeCase1, 0);

    }

    public function test_modThreeFaCases3()
    {
        $finiteSetOfStates = ['S0', 'S1', 'S2'];
        $inputArr =  ['1', '0', '1', '0', '1'];
        $initialState = 'S0';
        $acceptingStates = ['S0', 'S1', 'S2'];
        $transitionFunction = [
            ['S0', 0, 'S0'],
            ['S0', 1, 'S1'],
            ['S1', 0, 'S2'],
            ['S1', 1, 'S0'],
            ['S2', 0, 'S1'],
            ['S2', 1, 'S2']
        ];
        $modThreeCase1 = ModuloThree::ModThreeFA($finiteSetOfStates, $inputArr, $initialState,
            $acceptingStates, $transitionFunction);
        $this->assertEquals($modThreeCase1, 0);

    }

    public function test_modThreeCases4()
    {
        $modThreeCase1 = ModuloThree::modThree('A10101');
        $this->assertEquals($modThreeCase1, false);

    }

    public function test_modThreeFaCases4()
    {
        $finiteSetOfStates = ['S0', 'S1', 'S2'];
        $inputArr =  ['1', '0', '1', '0', '1'];
        $initialState = 'S0';
        $acceptingStates = ['S0', 'S1', 'S3'];
        $transitionFunction = [
            ['S0', 0, 'S0'],
            ['S0', 1, 'S1'],
            ['S1', 0, 'S2'],
            ['S1', 1, 'S0'],
            ['S2', 0, 'S1'],
            ['S2', 1, 'S2']
        ];
        $modThreeCase1 = ModuloThree::ModThreeFA($finiteSetOfStates, $inputArr, $initialState,
            $acceptingStates, $transitionFunction);
        $this->assertEquals($modThreeCase1, 1);

    }

    public function test_modThreeFaCases5()
    {
        $finiteSetOfStates = ['S0', 'S1', 'S2'];
        $inputArr =  ['1', '0', '1', '0', '1'];
        $initialState = 'S0';
        $acceptingStates = ['S0', 'S1'];
        $transitionFunction = [
            ['S0', 0, 'S0'],
            ['S0', 1, 'S1'],
            ['S1', 0, 'S2'],
            ['S1', 1, 'S0'],
            ['S2', 0, 'S1'],
            ['S2', 1, 'S2']
        ];
        $modThreeCase1 = ModuloThree::ModThreeFA($finiteSetOfStates, $inputArr, $initialState,
            $acceptingStates, $transitionFunction);
        $this->assertEquals($modThreeCase1, 1);

    }

    public function test_modThreeFaCases6()
    {
        $finiteSetOfStates = ['S0', 'S1', 'S2'];
        $inputArr =  ['1', '0', '1', '0', '1'];
        $initialState = 'S0';
        $acceptingStates = ['S0', 'S1', 'S3', 'S4'];
        $transitionFunction = [
            ['S0', 0, 'S0'],
            ['S0', 1, 'S1'],
            ['S1', 0, 'S2'],
            ['S1', 1, 'S0'],
            ['S2', 0, 'S1'],
            ['S2', 1, 'S2']
        ];
        $modThreeCase1 = ModuloThree::ModThreeFA($finiteSetOfStates, $inputArr, $initialState,
            $acceptingStates, $transitionFunction);
        $this->assertEquals($modThreeCase1, 1);

    }
}
