#!/usr/bin/env php
<?php
// application.php

require __DIR__.'/../vendor/autoload.php';

use Mh13\Command\UpdateContentsTablesCommand;
use Symfony\Component\Console\Application;


$application = new Application();

$application->add(new UpdateContentsTablesCommand());
$application->run();
