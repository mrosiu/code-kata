<?php

include_once 'RecentlyUsed.php';

class RecentlyUsedTest extends PHPUnit_Framework_TestCase
{
    protected $object;

    public function setUp()
    {
        $this->object = new RecentlyUsed();
        $this->object->push('Ania');
        $this->object->push('Jakób');
        $this->object->push('Miłosz');
    }

    public function testConstruction()
    {
        $list = new RecentlyUsed();
        $this->assertEquals(0, count($list));
    }

    public function testLifo()
    {

        $this->assertEquals('Miłosz', $this->object->pop());
        $this->assertEquals('Jakób', $this->object->pop());
        $this->assertEquals('Ania', $this->object->pop());
        
        $this->assertEquals(0, count($this->object));

        $this->setExpectedException('Exception');
        $this->object->pop();
        $this->fail('Should not be here');
    }

    public function testLookup()
    {
        $this->assertEquals('Jakób', $this->object->lookup(1));
    }

    /**
     * @expectedException Exception
     */
    public function testLookupOutOfBounds()
    {
        $this->object->lookup(4);
    }

    public function testNonUniquePush()
    {
        $this->object->push('Jakób');
        $this->assertEquals(3, count($this->object));

        $this->assertEquals('Jakób', $this->object->lookup(0));
        $this->assertEquals('Miłosz', $this->object->lookup(1));
        $this->assertEquals('Ania', $this->object->lookup(2));
    }

    /**
     * @expectedException Exception
     */
    public function testNullInsert()
    {
        $this->object->push(null);
    }

    public function testBoundedCapacity()
    {
        $this->object->setCapacity(3);
        $this->object->push('Wojtek');

        $this->assertEquals(3, count($this->object));

        $this->assertEquals('Wojtek', $this->object->lookup(0));
        $this->assertEquals('Miłosz', $this->object->lookup(1));
        $this->assertEquals('Jakób', $this->object->lookup(2));
    }


    /**
     * @expectedException InvalidArgumentException
     */
    public function testWeirdCapacity()
    {
        $this->object->setCapacity("Wrong");
    }
}
