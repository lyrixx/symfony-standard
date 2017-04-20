<?php

namespace AppBundle\Consumer;

use Psr\Log\LoggerInterface;
use Symfony\Component\Amqp\Broker;
use Symfony\Component\Amqp\Exception\NonRetryableException;
use Symfony\Component\Worker\Consumer\ConsumerInterface;
use Symfony\Component\Worker\MessageCollection;

class ConfigurableConsumer implements ConsumerInterface
{
    private $broker;
    private $logger;
    private $retry;
    private $queueName;

    public function __construct(Broker $broker, LoggerInterface $logger)
    {
        $this->broker = $broker;
        $this->logger = $logger;
    }

    public function consume(MessageCollection $messageCollection)
    {
        foreach ($messageCollection as $message) {
            dump([
                'exchange_name' => $message->getExchangeName(),
                'routing_key' => $message->getRoutingKey(),
                'headers' => $message->getHeaders(),
            ]);

            if ($this->retry) {
                $this->logger->warning('Going to retry.');
                try {
                    $this->broker->retry($message, $this->queueName);
                } catch (NonRetryableException $e) {
                    $this->logger->error($e->getMessage(), [
                        'exception' => $e,
                    ]);
                }
            }

            $this->broker->ack($message, \AMQP_NOPARAM, $this->queueName);
        }
    }

    public function setRetry($retry)
    {
        $this->retry = $retry;
    }

    public function setQueueName($queueName)
    {
        $this->queueName = $queueName;
    }
}
