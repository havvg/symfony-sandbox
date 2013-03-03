<?php

namespace Command\Demo;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class GreetCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('demo:greet')
            ->setDescription('Demo command to greet someone')
            ->addArgument('name', InputArgument::REQUIRED, 'Who do you want to greet?')
            ->addOption('yell', null, InputOption::VALUE_NONE, 'If set, the task will yell in uppercase letters.')
            ->setHelp(<<<EOF
The <info>%command.name%</info> command is a demo command to greet someone:

  <info>php %command.full_name% havvg</info>

You can also yell by providing the <comment>--yell</comment> option:

  <info>php %command.full_name% --yell havvg</info>
EOF
            )
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $text = sprintf('Hello %s!', $input->getArgument('name'));

        if ($input->getOption('yell')) {
            $text = strtoupper($text);
        }

        $output->writeln($text);
    }
}
