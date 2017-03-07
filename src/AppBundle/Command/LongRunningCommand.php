<?php

namespace AppBundle\Command;


use Psr\Log\LogLevel;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class LongRunningCommand extends ContainerAwareCommand
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('long-running')
            ->setDescription('Default description')
            ->addOption('one-shot', 'o', InputOption::VALUE_NONE, 'Only one loop?')
        ;
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $c = $this->getContainer();

        $logger = $c->get('logger');

        $anObject = new \stdClass;
        $anObject->firstPpt = 'foo';
        $anObject->secondePpt = 'bar';

        // Simple line log, with one stdClass and one Service
        $logger->log('notice', 'Hello {who}', [
            'who' => 'World',
            'an_object' => $anObject,
            'file_system' => $c->get('filesystem'),
        ]);

        $levels = (new \ReflectionClass(LogLevel::class))->getConstants();

        while (true) {
            foreach ($levels as $level) {
                $logger = $logger->withName($level);
                $logger->log($level, 'log at level "{level}".', [
                    'level' => $level,
                ]);
            }

            if ($input->getOption('one-shot')) {
                return;
            }

            // Change the log uuid
            $c->get('app.monolog.processor.id_processor')->__construct();

            usleep(500000);
        }

    }

}
