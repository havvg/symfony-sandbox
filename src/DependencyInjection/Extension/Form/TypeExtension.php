<?php

namespace DependencyInjection\Extension\Form;

use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\Finder\Finder;
use Symfony\Component\HttpKernel\DependencyInjection\Extension as BaseExtension;

class TypeExtension extends BaseExtension
{
    public function load(array $config, ContainerBuilder $container)
    {
        $typeDir = $container->getParameter('kernel.root_dir').'/../src/Form/Type';
        if (!is_dir($typeDir)) {
            return;
        }

        $types = Finder::create()
            ->files()
            ->name('*Type.php')
            ->in($typeDir)
        ;

        foreach ($types as $eachFile) {
            /* @var $eachFile \SplFileInfo */
            $fqcn = str_replace(
                array(
                    dirname(realpath($typeDir)).'/',
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
                $alias = Container::underscore($eachFile->getBasename('Type.php'));
                $serviceId = 'form.type.'.$alias;

                if ($container->has($serviceId)) {
                    continue;
                }

                $definition = new Definition($fqcn);
                $definition->addTag('form.type', array(
                    'alias' => $alias,
                ));

                $container->addDefinitions(array(
                     $serviceId => $definition,
                ));
            }
        }
    }
}
