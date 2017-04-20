<?php

namespace AppBundle\Consumer;

use Symfony\Component\Amqp\Broker;
use Symfony\Component\Worker\Consumer\ConsumerInterface;
use Symfony\Component\Worker\MessageCollection;

class DumpConsumer implements ConsumerInterface
{
    private $broker;

    public function __construct(Broker $broker)
    {
        $this->broker = $broker;
    }

    public function consume(MessageCollection $messageCollection)
    {
        foreach ($messageCollection as $message) {
            dump($message);

            $this->broker->ack($message);
        }
    }
}
