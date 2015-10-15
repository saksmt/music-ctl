<?php

namespace Smt\MpdMpcBundle\Provider;

use Smt\MpdBundle\Configuration\HostConfiguration;
use Smt\MpdBundle\Exception\ConfigurationNotFoundException;
use Smt\MpdBundle\Registry\ConfigurationRegistry;
use Smt\TrackTagsBundle\Entity\AbstractTagsCollection;
use Smt\TrackTagsBundle\Entity\TrackTagsCollectionInterface;
use Smt\TrackTagsBundle\Factory\TrackTagsCollectionFactoryInterface;
use Smt\TrackTagsBundle\Provider\TrackProviderInterface;

/**
 * Track provider
 * @package Smt\MpdMpcBundle\Provider
 * @author Kirill Saksin <kirillsaksin@yandex.ru>
 */
class MpcTrackProvider implements TrackProviderInterface
{

    private static $providerCommand = 'mpc -h %s -p %d -f \'[%%artist%%|%%performer%%]\t%%album%%\t%%title%%\t%%file%%\' current';

    /**
     * @var TrackTagsCollectionFactoryInterface
     */
    private $factory;

    /**
     * @var string
     */
    private $currentProviderCommand;

    /**
     * @param TrackTagsCollectionFactoryInterface $factory Track factory
     * @param ConfigurationRegistry $registry Configuration registry
     * @param string $configurationId Configuration ID
     * @throws ConfigurationNotFoundException
     */
    public function __construct(TrackTagsCollectionFactoryInterface $factory, ConfigurationRegistry $registry, $configurationId)
    {
        $this->factory = $factory;
        $config = $registry->get($configurationId);
        $host = $config->getHost();
        if ($config->getPassword() !== null) {
            $host = $config->getPassword() . '@' . $host;
        }
        $this->currentProviderCommand = sprintf(self::$providerCommand, $host, $config->getPort());
    }

    /**
     * @return TrackTagsCollectionInterface
     */
    public function get()
    {
        $data = $this->executeCommand();
        return $this->factory->createTrack()
            ->setAlbum($data->album)
            ->setArtist($data->artist)
            ->setPath($data->path)
            ->setTitle($data->title)
        ;
    }

    /**
     * @return object
     */
    private function executeCommand()
    {
        $result = explode("\t", substr(shell_exec($this->currentProviderCommand), 0, -1));
        $data = [];
        foreach (['artist', 'album', 'title', 'path'] as $pos => $key) {
            $data[$key] = $result[$pos];
        }
        return (object) $data;
    }
}
