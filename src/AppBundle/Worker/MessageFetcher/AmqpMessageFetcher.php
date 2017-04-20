<?php

namespace AppBundle\Worker\MessageFetcher;

use Symfony\Component\Amqp\Broker;
use Symfony\Component\Worker\MessageCollection;
use Symfony\Component\Worker\MessageFetcher\MessageFetcherInterface;

class AmqpMessageFetcher implements MessageFetcherInterface
{
    private $broker;
    private $queueName;
    private $flags;

    public function __construct(Broker $broker, $queueName, $autoAck = false)
    {
        $this->broker = $broker;
        $this->queueName = $queueName;
        $this->flags = $autoAck ? \AMQP_AUTOACK : \AMQP_NOPARAM;
    }

    public function fetchMessage()
    {
        $msg = $this->broker->get($this->queueName, $this->flags);

        if (false === $msg) {
            return false;
        }

        return new MessageCollection($msg);
    }

    public function setQueueName($queueName)
    {
        $this->queueName = $queueName;
    }
}
