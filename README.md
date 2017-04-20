symfony-amqp
============

## Installation

    # on linnux
    # sudo apt-get install php-amqp

    composer update

## How to use

### simple usage

    bin/console  worker:amqp:publish --routing_key=queue_hello "my message"
    bin/console  worker:amqp:run queue_hello


### play with the retry

    bin/console  worker:amqp:publish --routing_key=retry_strategy_constant_1 "my message"
    bin/console  worker:amqp:run retry_strategy_constant_1
