<?php

namespace AppBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class WorkerAmqpCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('worker:amqp:run')
            ->setDescription('Run an AMQP worker with a configureable fetcher and consumer.')
            ->setDefinition(array(
                new InputArgument('queue_name', InputArgument::REQUIRED, 'The queue name'),
                new InputOption('retry', null, InputOption::VALUE_NONE),
            ))
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $container = $this->getContainer();

        $loop = $container->get('worker.worker.configurable_worker');

        $fetcher = $container->get('app.configurable_amqp_message_fetcher');
        $fetcher->setQueueName($input->getArgument('queue_name'));

        $consumer = $container->get('app.configurable_consumer');
        $consumer->setRetry($input->getOption('retry'));
        $consumer->setQueueName($input->getArgument('queue_name'));

        $container->get('logger')->info('queue: {queue}, retry: {retry}', [
            'queue' => $input->getArgument('queue_name'),
            'retry' => $input->getOption('retry'),
        ]);

        pcntl_signal(SIGTERM, function () use ($loop) {
            $loop->stop('Signaled with SIGTERM.');
        });
        pcntl_signal(SIGINT, function () use ($loop) {
            $loop->stop('Signaled with SIGINT.');
        });

        $loop->run();
    }
}
