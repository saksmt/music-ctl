<?php

set_time_limit(0);

require_once __DIR__ . '/vendor/autoload.php';
require_once 'phar://' . \Paths::LIB . '/vendors.phar/vendor/autoload.php';

use Application\Kernel;
use Doctrine\Common\Annotations\AnnotationRegistry;
use Application\Application;
use Symfony\Component\Console\Input\ArgvInput;
use Symfony\Component\Debug\Debug;

$input = new ArgvInput();
$env = $input->getParameterOption(array('--env', '-e'), getenv('SYMFONY_ENV') ?: 'prod');
$debug = getenv('SYMFONY_DEBUG') !== '0' && !$input->hasParameterOption(array('--no-debug', '')) && $env !== 'prod';

if ($debug) {
    Debug::enable();
}

AnnotationRegistry::registerAutoloadNamespaces([
    'Doctrine\ORM\Mapping' => 'phar://' . Paths::LIB . '/vendors.phar/vendor/doctrine/orm/lib'
]);

$kernel = new Kernel($env, $debug);
$kernel->boot();
$application = new Application($kernel);
$application->run($input);
return $application;