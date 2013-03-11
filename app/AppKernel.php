<?php

use HttpKernel\Kernel;

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

            new Havvg\Bundle\DRYBundle\HavvgDRYBundle(),

            new Knp\Bundle\MenuBundle\KnpMenuBundle(),
            new Knp\Bundle\GaufretteBundle\KnpGaufretteBundle(),
            new Knp\Bundle\PaginatorBundle\KnpPaginatorBundle(),

            new Craue\FormFlowBundle\CraueFormFlowBundle(),
        );

        if (in_array($this->getEnvironment(), array('dev', 'test', 'test_functional'))) {
            $bundles[] = new Symfony\Bundle\WebProfilerBundle\WebProfilerBundle();
        }

        return $bundles;
    }

    public function getName()
    {
        return "Sandbox";
    }
}
