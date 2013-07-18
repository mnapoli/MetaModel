<?php

namespace UnitTest\MetaModel\Parser;

use MetaModel\Parser\Model\PropertyAccess;
use MetaModel\Parser\Model\Selector;
use MetaModel\Parser\PropertyAccessParser;

class PropertyAccessParserTest extends \PHPUnit_Framework_TestCase
{
    public function testParseSimplePropertyAccess()
    {
        $parser = new PropertyAccessParser();

        $this->assertTrue($parser->match('id'));

        $propertyAccess = $parser->parse('id');

        $this->assertTrue($propertyAccess instanceof PropertyAccess);
        $this->assertEquals('id', $propertyAccess->getProperty());
    }

    public function testMatching()
    {
        $parser = new PropertyAccessParser();

        $this->assertTrue($parser->match('article'));
        $this->assertTrue($parser->match('article_test'));
        $this->assertTrue($parser->match('ARTICLE'));
    }

    public function testNotMatching()
    {
        $parser = new PropertyAccessParser();

        $this->assertFalse($parser->match('article()'));
        $this->assertFalse($parser->match('article(1)'));
        $this->assertFalse($parser->match('article\\test'));
    }
}
