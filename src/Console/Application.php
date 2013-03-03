<?php

namespace Console;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Bundle\FrameworkBundle\Console\Application as BaseApplication;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\Finder\Finder;

class Application extends BaseApplication
{
    protected function registerCommands()
    {
        parent::registerCommands();

        $this->addCommands($this->loadCommands());
    }

    /**
     * Load all commands from the Command directory.
     *
     * @return Command[]
     */
    protected function loadCommands()
    {
        $container = $this->getKernel()->getContainer();
        $commandDir = $container->getParameter('kernel.root_dir').'/../src/Command';
        if (!is_dir($commandDir)) {
            return array();
        }

        $commandFiles = Finder::create()
            ->files()
            ->name('*Command.php')
            ->in($commandDir)
        ;

        $commands = array();
        foreach ($commandFiles as $eachFile) {
            /* @var $eachFile \SplFileInfo */
            $fqcn = str_replace(
                array(
                    dirname(realpath($commandDir)).'/',
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
                $reflection = new \ReflectionClass($fqcn);
                if ($reflection->isInstantiable()) {
                    $command = $reflection->newInstance();

                    if ($command instanceof ContainerAwareCommand) {
                        $command->setContainer($container);
                    }

                    $commands[] = $command;
                }
            }
        }

        return $commands;
    }
}
