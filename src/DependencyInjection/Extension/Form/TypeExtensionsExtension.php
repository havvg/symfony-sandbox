<?php

namespace DependencyInjection\Extension\Form;

use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\Finder\Finder;
use Symfony\Component\HttpKernel\DependencyInjection\Extension as BaseExtension;

class TypeExtensionsExtension extends BaseExtension
{
    public function load(array $config, ContainerBuilder $container)
    {
        $extensionDir = $container->getParameter('kernel.root_dir').'/../src/Form/Extension';
        if (!is_dir($extensionDir)) {
            return;
        }

        $extensions = Finder::create()
            ->files()
            ->name('*Extension.php')
            ->in($extensionDir)
        ;

        foreach ($extensions as $eachFile) {
            /* @var $eachFile \SplFileInfo */
            $fqcn = str_replace(
                array(
                    dirname(realpath($extensionDir)).'/',
                    DIRECTORY_SEPARATOR,
                    '.php',
                ),
                array(
                    'Form\\',
                    '\\',
                    '',
                ),
                $eachFile->getRealPath()
            );
            if (class_exists($fqcn)) {
                $serviceId = 'form.type_extension.'.Container::underscore($eachFile->getBasename('Extension.php'));

                if ($container->has($serviceId)) {
                    continue;
                }

                $definition = new Definition($fqcn);
                $definition->addTag('form.type_extension', array(
                    'alias' => 'form',
                ));

                $container->addDefinitions(array(
                     $serviceId => $definition,
                ));
            }
        }
    }
}
