<?php
namespace App\Classes;

class ModuloThree {

    const states = [
        "S0" => 0,
        "S1" => 1,
        "S2" => 2
    ];

    /**
     * ModThree will base on the input string (binary string) to determine the final
     * value of the state.
     * @param String $input
     * @return bool
     */
    public static function modThree(String $input)
    {
        //set states
        $states = self::states;

        //set initial state
        $state = 'S0';

        //lead string into char list array.
        $chars = str_split($input);
        //loop through each character in the char list.
        foreach ($chars as $char) {
            //only return meaningful result if the character is numeric value.
            if (is_numeric($char)) {
                $state = self::processingState($state, $char);
            } else {
                return false;
            }
        }

        //return the value of the final state
        if (isset($states[$state])) {
            return $states[$state];
        } else {
            return false;
        }
    }

    /**
     * State processor will according to the provided state and input to
     * determine the value of the next state.
     * @param $state
     * @param $input
     * @return string
     */
    public static function processingState($state, $input)
    {
        //holding the future state value.
        $nextState = "";

        //The following function is written based on provided FSM design from the assignment doc.
        if ($state == 'S0') {
            if ($input == 1) {
                $nextState = 'S1';
            }

            if ($input == 0) {
                $nextState = 'S0';
            }
        }

        if ($state == 'S1') {
            if ($input == 1) {
                $nextState = 'S0';
            }

            if ($input == 0) {
                $nextState = 'S2';
            }
        }

        if ($state == 'S2') {
            if ($input == 1) {
                $nextState = 'S2';
            }

            if ($input == 0) {
                $nextState = 'S1';
            }
        }

        return $nextState;
    }

    /**
     * This function will generate FSM based on provided information, example:
     * $finiteSetOfStates = ['S0', 'S1', 'S2'];
     * $inputArr =  [1,1,0];
     * $initialState = 'S0';
     * $acceptingStates = ['S0', 'S1', 'S2'];
     * $transitionFunction = [
     *   ['S0', 0, 'S0'],
     *   ['S0', 1, 'S1'],
     *   ['S1', 0, 'S2'],
     *   ['S1', 1, 'S0'],
     *   ['S2', 0, 'S1'],
     *   ['S2', 1, 'S2']
     * ];
     * @param $finiteSetOfStates
     * @param $inputCharSet
     * @param $initialState
     * @param $acceptingStates
     * @param $transitionFunction
     * @return bool|mixed
     */
    public static function ModThreeFA($finiteSetOfStates, $inputCharSet, $initialState, $acceptingStates, $transitionFunction)
    {
        //set states
        $states = self::states;

        //only processing states provided in the finite state set
        $statesToBeProcess = array_intersect($finiteSetOfStates, $acceptingStates);

        //set current state
        $previousState = '';
        $currentState = $initialState;

        //loop through the input string and use transition functions to process it
        foreach ($inputCharSet as $char) {
            if (is_numeric($char)) {
                //calling transition functions processor to process the provided functions
                $previousState = $currentState;
                $currentState = self::processingMappedStates($transitionFunction, $currentState, $char);


                if (!in_array($currentState, $statesToBeProcess)) {

                    if (isset($states[$previousState])) {
                        return $states[$previousState];
                    } else {
                        return false;
                    }
                }

                //error out if empty here, due to invalid input.
                if (empty($currentState)) {
                    return false;
                }
            } else {
                return false;
            }
        }

        //return the value of the final state
        if (isset($states[$currentState])) {
            return $states[$currentState];
        } else {
            return false;
        }

    }

    /**
     * This function will loop through provided transition function set to find match state/input pair and return its
     * designated state.
     * @param $transitionFunction
     * @param $state
     * @param $input
     * @return mixed|string
     */
    public static function processingMappedStates ($transitionFunction, $state, $input)
    {
        //holding the future state value.
        $nextState = "";

        //loop through the transition function set to find the match state / input and its result.
        foreach ($transitionFunction as $function) {
            if ($function[0] == $state && $function[1] == $input) {
                $nextState = $function[2];
            }
        }

        return $nextState;
    }
}
