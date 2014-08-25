#!/usr/bin/env php
<?php

require_once __DIR__.'/app/bootstrap.php.cache';
require_once __DIR__.'/app/AppKernel.php';

$kernel = new AppKernel('dev', true);
$kernel->boot();

$dude = new Acme\Bundle\DebugBundle\Entity\Dude();

$deliveryAddress = new Acme\Bundle\DebugBundle\Entity\Address($dude);
$dude->setDeliveryAddress($deliveryAddress);
$billingAddress = new Acme\Bundle\DebugBundle\Entity\Address($dude);
$dude->setBillingAddress($billingAddress);

$em = $kernel->getContainer()->get('doctrine.orm.entity_manager');

$em->persist($dude);

$em->flush();

/*
Doctrine\DBAL\DBALException: An exception occurred while executing 'INSERT INTO Address (id, dude_id) VALUES (?, ?)' with params [3, 3]:

SQLSTATE[23505]: Unique violation: 7 ERROR:  duplicate key value violates unique constraint "uniq_c2f3561d4030e164"
DETAIL:  Key (dude_id)=(3) already exists. in /home/greg/dev/tmp/doctrine-many/vendor/doctrine/dbal/lib/Doctrine/DBAL/DBALException.php on line 91
 */
