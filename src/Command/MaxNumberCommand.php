<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use App\Classes\NumberManager;
use Symfony\Component\Console\Question\Question;

class MaxNumberCommand extends Command
{
    protected static $defaultName = 'app:get-maxvalue';

    private $numberManager;

    public function __construct(NumberManager $numberManager)
    {
        $this->numberManager = $numberManager;

        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setDescription('Get max values in series from given test cases')
            ->addArgument('testCasesNumber', InputArgument::REQUIRED, 'Number of test cases');       
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $testCasesNumber = $input->getArgument('testCasesNumber');

        if ($this->isInvalidArgument($testCasesNumber)) {
            $io->note(sprintf('Argument is not number or is out of range 1 <= n <= 10 : %s', $testCasesNumber));
            return 1;
        }

        $helper = $this->getHelper('question');

        $testCases = [];
        for($testCaseIndex = 1; $testCaseIndex <= $testCasesNumber ; $testCaseIndex++)
        {
            $question = new Question('Test case ' . $testCaseIndex . ': ', false);
            $answer = $helper->ask($input, $output, $question);
            if($this->isInvalidTestCase($answer)){
                $io->note(sprintf('Argument is not number or is out of range 1 <= n <= 99999 : %s', $answer));
                return 1;
            }
            array_push($testCases, $answer);
        }
            $result = $this->numberManager->getMaxValuesFromSeriesWithGivenSizes($testCases);
            $io->success($result);
    
        return 0;
    }

    private function isInvalidArgument($numberTestCases)
    {
        return !is_numeric($numberTestCases) || $numberTestCases < 1 || $numberTestCases > 10;
    }

    private function isInvalidTestCase($testCase)
    {
        return !is_numeric($testCase) || $testCase < 1 || $testCase > 99999;
    }
}
