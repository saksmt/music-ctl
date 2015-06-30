<?php

use Symfony\Component\DependencyInjection\ContainerInterface;

/** @var ContainerInterface $container */

$locale = getenv('LANG');
if (empty($locale)) {
    $locale = getenv('LC_ALL');
}
if (!empty($locale)) {
    $locale = explode('_', $locale)[0];
    $container->setParameter('locale', $locale);
}

$container->setParameter('dbPathPrefix', \Paths::DB);