<?php

namespace Acme\DemoBundle\Tests\Controller;

use Buzz\Browser;
use Buzz\Client\Curl;
use Guzzle\Http\Client;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DebugControllerTest extends WebTestCase
{
    public function getFormTests()
    {
        return array(
            array('yes', true),
            array('no', false),
            array('no', 0),
            array('no', '0'),
            array('no', ''),
        );
    }

    /** @dataProvider getFormTests */
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

    public function getFormWithHttpTransportTests()
    {
        return array(
            array('yes', true),
            array('no', false),
        );
    }

    /**
     * @dataProvider getFormWithHttpTransportTests
     */
    public function testFormWithHttpTransport($expected, $value)
    {
        $url = 'http://sf-debug-form-false.debug.localhost/app_dev.php/debug';
        $data = array(
            'debug' => array(
                'myCheckbox' => $value,
            ),
        );

        $browser = new Browser(new Curl());
        $response = $browser->submit($url, $data);
        $this->assertSame($expected, $response->getContent());

        $client = new Client();
        $request = $client->createRequest('POST', $url, null, $data);
        $this->assertSame($expected, (string) $request->send()->getBody());
    }
}
