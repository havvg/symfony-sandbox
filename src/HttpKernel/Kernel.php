<?php

namespace HttpKernel;

use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBag;
use Symfony\Component\Finder\Finder;
use Symfony\Component\HttpKernel\Kernel as BaseKernel;

abstract class Kernel extends BaseKernel
{
    protected function getContainerBuilder()
    {
        $builder = new ContainerBuilder(new ParameterBag($this->getKernelParameters()));

        $extensionDir = __DIR__.'/../DependencyInjection';
        if (is_dir($extensionDir)) {
            $extensionFiles = Finder::create()
                ->files()
                ->name('*Extension.php')
                ->in($extensionDir)
            ;

            foreach ($extensionFiles as $eachFile) {
                /* @var $eachFile \SplFileInfo */
                $fqcn = str_replace(
                    array(
                        dirname(realpath($extensionDir)).'/',
                        DIRECTORY_SEPARATOR,
                        '.php',
                    ),
                    array(
                        '',
                        '\\',
                        '',
                    ),
                    $eachFile->getRealPath()
                );
                if (class_exists($fqcn)) {
                    /* @var $extension ExtensionInterface */
                    $extension = new $fqcn;
                    $builder->registerExtension($extension);

                    if (!count($builder->getExtensionConfig($extension->getAlias()))) {
                        $builder->loadFromExtension($extension->getAlias(), array());
                    }
                }
            }
        }

        return $builder;
    }

    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        $configDir = $this->getRootDir().'/config';

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

        if (is_dir($configDir.'/extensions')) {
            /*
             * Load all extension specific configuration files.
             */
            $extensions = Finder::create()
                ->files()
                ->name('*.yml')
                ->in($configDir.'/extensions')
            ;
            foreach ($extensions as $eachFile) {
                $loader->load($eachFile->getRealPath());
            }
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

        /*
         * Load all environment specific extension configuration files.
         */
        if (is_dir($envConfigDir.'/extensions')) {
            $envExtensions = Finder::create()
                ->files()
                ->name('*.yml')
                ->in($envConfigDir.'/extensions')
            ;
            foreach ($envExtensions as $eachFile) {
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
}
