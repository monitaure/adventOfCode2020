<?php

namespace AOC\AdventOfCode2020\Utils;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Finder\Finder;

abstract class AOCCommand extends Command
{
    protected const OPTION_FILE = 'file';

    protected OutputInterface $output;
    protected string $inputPath;

    protected function configure()
    {
        $this->addArgument(self::OPTION_FILE, InputArgument::OPTIONAL, default: '*');
    }

    abstract protected function executeInput(string $input): void;

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->output = $output;

        $finder = (new Finder())
            ->in($this->inputPath)
            ->name($input->getArgument(self::OPTION_FILE));
        foreach ($finder as $file) {
            echo "{$file->getFilenameWithoutExtension()}:" . PHP_EOL;
            $this->executeInput(trim($file->getContents()));
            echo "----------" . PHP_EOL;
        }

        return Command::SUCCESS;
    }
}