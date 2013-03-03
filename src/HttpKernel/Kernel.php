<?php

namespace HttpKernel;

use Havvg\Bundle\DRYBundle\Kernel\ContainerConfigurationRegistry;

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
        $registry = new ContainerConfigurationRegistry($this);
        $registry->register($loader);
    }
}
