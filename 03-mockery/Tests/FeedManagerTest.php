<?php

namespace Tests;

use Model\FeedManager;
use Mockery;

class FeedManagerTest extends \PHPUnit_Framework_TestCase
{
    protected $object;
    protected $mock;
    protected $configMock;

    public function tearDown()
    {
        Mockery::close();
    }

    public function setUp()
    {
        $this->mock = Mockery::mock('\Buzz\Browser');
        $this->object = new FeedManager($this->mock);
        $this->configMock = Mockery::mock('\Model\FeedConfigInterface', array('getUrl' => 'http://xlab.pl/en/feed'));
    }

    /**
     * @expectedException \RuntimeException
     */
    public function testBadConfiguration()
    {
        $this->object->fetchItemsByKeyword('Jakub');
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testEmptyKeyword()
    {
        $this->object->setupFeed($this->configMock);
        $this->object->fetchItemsByKeyword("");
    }

    /**
     * @expectedException \RuntimeException
     */
    public function testValidXml()
    {
        $this->mock->shouldReceive('get')->once()->andReturn('');
        $this->object->setupFeed($this->configMock);
        $this->object->fetchItemsByKeyword("Null");
    }

    public function testRetrieve()
    {
        $this->mock->shouldReceive('get')->once()->andReturn(file_get_contents(__DIR__ . '/fixtures.xml'));
        $this->object->setupFeed($this->configMock);
        $items = $this->object->fetchItemsByKeyword("Symfony");
        $this->assertCount(4, $items);
        $this->assertEquals('PHPCon Poland 2013', $items[0]['title']);
    }

    /**
     * @expectedException \Exception\WonkyConnectionException
     */
    public function testWonkyConnection()
    {
        $this->mock->shouldReceive('get')->with('http://xlab.pl/en/feed')->once()->andThrow('\Buzz\Exception\ClientException');

        $this->object->setupFeed($this->configMock);
        $items = $this->object->fetchItemsByKeyword("Symfony");
    }

}
