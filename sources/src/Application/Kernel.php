<?php

namespace Application;

use AppBundle\AppBundle;
use Doctrine\Bundle\DoctrineBundle\DoctrineBundle;
use Smt\FavoritesBundle\SmtFavoritesBundle;
use Smt\MpdBundle\SmtMpdBundle;
use Smt\MpdMpcBundle\SmtMpdMpcBundle;
use Smt\TrackTagsBundle\SmtTrackTagsBundle;
use Symfony\Bundle\FrameworkBundle\FrameworkBundle;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\HttpKernel\Kernel as BaseKernel;

/**
 * Application kernel
 * @package Application
 * @author Kirill Saksin <kirill.saksin@billing.ru>
 */
class Kernel extends BaseKernel
{

    /** {@inheritdoc} */
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
            new SmtFavoritesBundle(),
        ];
    }

    /** {@inheritdoc} */
    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        $loader->load(dirname(dirname(__DIR__)) . '/app/config/config.xml');
    }

    /** {@inheritdoc} */
    public function getRootDir()
    {
        return dirname(dirname(__DIR__)) . '/app/';
    }

    /** {@inheritdoc} */
    public function getLogDir()
    {
        return \Paths::LOG;
    }

    /** {@inheritdoc} */
    public function getCacheDir()
    {
        return \Paths::CACHE;
    }
}
