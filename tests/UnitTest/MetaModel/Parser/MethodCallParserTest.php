<?php

namespace UnitTest\MetaModel\Parser;

use MetaModel\Parser\MethodCallParser;
use MetaModel\Parser\Model\MethodCall;

class MethodCallParserTest extends \PHPUnit_Framework_TestCase
{
    public function testParseSimpleMethodCall()
    {
        $parser = new MethodCallParser();

        $this->assertTrue($parser->match('getStuff()'));

        $methodCall = $parser->parse('getStuff()');

        $this->assertTrue($methodCall instanceof MethodCall);
        $this->assertEquals('getStuff', $methodCall->getMethod());
    }

    public function testMatching()
    {
        $parser = new MethodCallParser();

        $this->assertTrue($parser->match('getStuff()'));
        $this->assertTrue($parser->match('get_stuff()'));
        $this->assertTrue($parser->match('GET_STUFF()'));
    }

    public function testNotMatching()
    {
        $parser = new MethodCallParser();

        $this->assertFalse($parser->match('foo'));
        $this->assertFalse($parser->match('foo(1)'));
    }
}
