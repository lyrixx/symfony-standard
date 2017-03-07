<?php

namespace AppBundle\Monolog\Processor;

class IdProcessor
{
    private $id;

    public function __construct()
    {
        $this->id = mt_rand();
    }

    public function __invoke(array $record)
    {
        $record['extra']['log_uuid'] = $this->id;

        return $record;
    }
}
