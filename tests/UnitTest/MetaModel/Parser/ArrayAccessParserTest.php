<?php

namespace UnitTest\MetaModel\Parser;

use MetaModel\Model\ArrayAccess;
use MetaModel\Parser\ArrayAccessParser;

class ArrayAccessParserTest extends \PHPUnit_Framework_TestCase
{
    public function testParseIntArrayAccess()
    {
        $parser = new ArrayAccessParser();

        $arrayAccess = $parser->parse('[0]');

        $this->assertTrue($arrayAccess instanceof ArrayAccess);
        $this->assertSame(0, $arrayAccess->getKey());
    }

    public function testParseStringArrayAccess()
    {
        $parser = new ArrayAccessParser();

        $arrayAccess = $parser->parse('[id]');

        $this->assertTrue($arrayAccess instanceof ArrayAccess);
        $this->assertSame('id', $arrayAccess->getKey());
    }

    public function testMatching()
    {
        $parser = new ArrayAccessParser();

        $this->assertTrue($parser->match('[10]'));
        $this->assertTrue($parser->match('[foo]'));
        $this->assertTrue($parser->match('[foo_bar]'));
        $this->assertTrue($parser->match('[FOO]'));
    }

    public function testNotMatching()
    {
        $parser = new ArrayAccessParser();

        $this->assertFalse($parser->match('['));
        $this->assertFalse($parser->match(']'));
        $this->assertFalse($parser->match('[]'));
        $this->assertFalse($parser->match('[foo[bar]]'));
        $this->assertFalse($parser->match('article'));
        $this->assertFalse($parser->match('[article'));
        $this->assertFalse($parser->match('article]'));
        $this->assertFalse($parser->match('(article)'));
    }
}
