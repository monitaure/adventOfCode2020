#!/usr/bin/env php
<?php
// application.php

require __DIR__  . '/vendor/autoload.php';

use Symfony\Component\Console\Application;

$application = new Application();

$application->add(new \AOC\AdventOfCode2020\Day3\Day3());

$application->run();
