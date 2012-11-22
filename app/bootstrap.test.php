<?php

$testEnvs = array(
    'test',
    'test_functional',
);

foreach ($testEnvs as $eachEnv) {
    passthru(sprintf(
        'php "%s/console" cache:clear --env=%s --no-warmup',
        __DIR__,
        $eachEnv
    ));
}

require_once __DIR__.'/bootstrap.php.cache';
require_once __DIR__.'/../app/AppKernel.php';

require_once __DIR__.'/../tests/AbstractTest.php';
require_once __DIR__.'/../tests/AbstractFunctionalTest.php';

$kernel = new AppKernel('test', true);
$kernel->boot();
