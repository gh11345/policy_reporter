<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Classes\ModuloThree;

class RunModuloThree extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'run:modulo-three';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $input = '1010';
        $finiteSetOfStates = ['S0', 'S1', 'S2'];
        $inputArr =  [1,1,0];
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

        $modThree = ModuloThree::modThree($input);
        $modThreeFA = ModuloThree::ModThreeFA($finiteSetOfStates, $inputArr, $initialState,
            $acceptingStates, $transitionFunction);

        $this->info("Standard FSM result: ". $modThree);
        $this->info("Advanced FSM result: ". $modThreeFA);

        return Command::SUCCESS;
    }
}
