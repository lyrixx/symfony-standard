<?php

namespace AppBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Amqp\Broker;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class PublishCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('worker:amqp:publish')
            ->setDescription('Publish a message to AMQP')
            ->addArgument('message', InputArgument::OPTIONAL, 'A message', date('H:i:s'))
            ->addOption('routing_key', 'r', InputOption::VALUE_REQUIRED, 'A routing key')
            ->addOption('exchange', 'x', InputOption::VALUE_REQUIRED, 'An exchange', Broker::DEFAULT_EXCHANGE)
            ->addOption('nb', null, InputOption::VALUE_REQUIRED, 'Number of message', 1)
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $broker = $this->getContainer()->get('amqp.broker');

        $nb = $input->getOption('nb');

        for ($i = 0; $i < $nb; ++$i) {
            $broker->publish($input->getOption('routing_key'), $input->getArgument('message'), array(
                'exchange' => $input->getOption('exchange'),
            ));
        }
    }
}
