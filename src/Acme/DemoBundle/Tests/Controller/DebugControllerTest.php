<?php

namespace Acme\DemoBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DebugControllerTest extends WebTestCase
{
    public function getTests()
    {
        return array(
            array('yes', true),
            array('no', false),
            array('no', 0),
            array('no', '0'),
            array('no', ''),
        );
    }

    /** @dataProvider getTests */
    public function testForm($expected, $value)
    {
        $client = static::createClient();

        $crawler = $client->request('POST', '/debug', array(
            'debug' => array(
                'myCheckbox' => $value,
            ),
        ));

        $this->assertSame($expected, $client->getResponse()->getContent());
    }
}
