<?php

use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\Finder\Finder;
use Symfony\Component\HttpKernel\Kernel;

class AppKernel extends Kernel
{
    public function registerBundles()
    {
        $bundles = array(
            new Symfony\Bundle\FrameworkBundle\FrameworkBundle(),
            new Symfony\Bundle\SecurityBundle\SecurityBundle(),
            new Symfony\Bundle\TwigBundle\TwigBundle(),
            new Symfony\Bundle\MonologBundle\MonologBundle(),
            new Symfony\Bundle\SwiftmailerBundle\SwiftmailerBundle(),
            new Symfony\Bundle\AsseticBundle\AsseticBundle(),
            new Sensio\Bundle\FrameworkExtraBundle\SensioFrameworkExtraBundle(),
            new Knp\Bundle\MenuBundle\KnpMenuBundle(),
            new Knp\Bundle\GaufretteBundle\KnpGaufretteBundle(),
            new Knp\Bundle\PaginatorBundle\KnpPaginatorBundle(),
            new Craue\FormFlowBundle\CraueFormFlowBundle(),
            new Mopa\Bundle\BootstrapBundle\MopaBootstrapBundle(),
            new Havvg\Bundle\DRYBundle\HavvgDRYBundle(),
        );

        if (in_array($this->getEnvironment(), array('dev', 'test', 'test_functional'))) {
            $bundles[] = new Symfony\Bundle\WebProfilerBundle\WebProfilerBundle();
        }

        return $bundles;
    }

    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        $configDir = __DIR__.'/config';

        /*
         * Load all globally defined configuration files.
         */
        $global = Finder::create()
            ->files()
            ->name('*.yml')
            ->in($configDir)
            ->depth('< 1')
        ;
        /* @var $eachFile \SplFileInfo */
        foreach ($global as $eachFile) {
            $loader->load($eachFile->getRealPath());
        }

        /*
         * Load all bundle specific configuration files.
         */
        $bundles = Finder::create()
            ->files()
            ->name('*.yml')
            ->in($configDir.'/bundles')
        ;
        foreach ($bundles as $eachFile) {
            $loader->load($eachFile->getRealPath());
        }

        /*
         * Load all configuration files defining services.
         */
        $services = Finder::create()
            ->files()
            ->name('*.yml')
            ->in($configDir.'/services')
        ;
        foreach ($services as $eachFile) {
            $loader->load($eachFile->getRealPath());
        }

        /*
         * Populate configuration with global defaults.
         */
        $defaultEnv = Finder::create()
            ->files()
            ->name('*.yml')
            ->in($configDir.'/environments')
            ->depth('< 1')
        ;
        foreach ($defaultEnv as $eachFile) {
            $loader->load($eachFile->getRealPath());
        }

        /*
         * Load environment specific configuration.
         */
        $envConfigDir = $configDir.'/environments/'.$this->getEnvironment();

        /*
         * Load all environment specific bundle configuration files.
         */
        if (is_dir($envConfigDir.'/bundles')) {
            $envBundles = Finder::create()
                ->files()
                ->name('*.yml')
                ->in($envConfigDir.'/bundles')
            ;
            foreach ($envBundles as $eachFile) {
                $loader->load($eachFile->getRealPath());
            }
        }

        $loader->load($envConfigDir.'/parameters.yml');
        $loader->load($envConfigDir.'/config.yml');

        /*
         * Load optional local environment specific modifications.
         */
        if (file_exists($envConfigDir.'/local.yml')) {
            $loader->load($envConfigDir.'/local.yml');
        }
    }

    public function getName()
    {
        return "Sandbox";
    }
}
