<?php

namespace Application;

use AppBundle\AppBundle;
use Doctrine\Bundle\DoctrineBundle\DoctrineBundle;
use Smt\MpdBundle\SmtMpdBundle;
use Smt\MpdMpcBundle\SmtMpdMpcBundle;
use Smt\TrackTagsBundle\SmtTrackTagsBundle;
use Symfony\Bundle\FrameworkBundle\FrameworkBundle;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\HttpKernel\Kernel as BaseKernel;

class Kernel extends BaseKernel
{

    /** @inheritdoc */
    public function registerBundles()
    {
        return [

            // vendor

            new FrameworkBundle(),
            new DoctrineBundle(),

            // src

            new AppBundle(),
            new SmtMpdBundle(),
            new SmtMpdMpcBundle(),
            new SmtTrackTagsBundle(),
        ];
    }

    /** @inheritdoc */
    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        $loader->load(dirname(dirname(__DIR__)) . '/app/config/config.xml');
    }

    public function getRootDir()
    {
        return dirname(dirname(__DIR__)) . '/app/';
    }

    public function getLogDir()
    {
        return \Paths::LOG;
    }

    public function getCacheDir()
    {
        return \Paths::CACHE;
    }
}