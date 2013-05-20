<?php

include_once 'RomanConverter.php';

/** @author Wojciech Sznapka <wojciech.sznapka@xsolve.pl> */
class RomanConverterTest extends PHPUnit_Framework_TestCase
{
    protected $converter;

    protected function setUp()
    {
        $this->converter = new RomanConverter();
    }

    public function testEmpty()
    {
        $this->assertEquals('', $this->converter->convert(''));
    }

    /**
     * @dataProvider provideTestData
     */
    public function testConversions($arabic, $roman)
    {
        $this->assertEquals($roman, $this->converter->convert($arabic));
    }

    public function provideTestData()
    {
        return array(
            array(1, 'I'),
            array(2, 'II'),
            array(4, 'IV'),
            array(5, 'V'),
            array(6, 'VI'),
            array(9, 'IX'),
            array(10, 'X'),
            array(40, 'XL'),
            array(45, 'XLV'),
            array(90, 'XC'),
            array(100, 'C'),
            array(400, 'CD'),
            array(500, 'D'),
            array(900, 'CM'),
            array(1000, 'M'),
            array(3497, 'MMMCDXCVII'),
        );
    }
}
