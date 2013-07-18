<?php

namespace UnitTest\MetaModel\Parser;

use MetaModel\Model\IdSelector;
use MetaModel\Parser\IdSelectorParser;

class IdSelectorParserTest extends \PHPUnit_Framework_TestCase
{
    public function testParseSimpleIdSelector()
    {
        $parser = new IdSelectorParser();

        $this->assertTrue($parser->match('Article(1)'));

        $selector = $parser->parse('Article(1)');

        $this->assertTrue($selector instanceof IdSelector);
        $this->assertEquals('Article', $selector->getName());
        $this->assertEquals(1, $selector->getId());
    }

    public function testParseNamespaceIdSelector()
    {
        $parser = new IdSelectorParser();

        $this->assertTrue($parser->match('My\Article(1)'));

        $selector = $parser->parse('My\Article(1)');

        $this->assertTrue($selector instanceof IdSelector);
        $this->assertEquals('My\Article', $selector->getName());
        $this->assertEquals(1, $selector->getId());
    }

    public function testMatching()
    {
        $parser = new IdSelectorParser();

        $this->assertTrue($parser->match('Article(1)'));
        $this->assertTrue($parser->match('My\Article(1)'));
        $this->assertTrue($parser->match('My_Article(1)'));
    }

    public function testNotMatching()
    {
        $parser = new IdSelectorParser();

        $this->assertFalse($parser->match('Article'));
        $this->assertFalse($parser->match('Article()'));
        $this->assertFalse($parser->match('Article(1)(1)'));
        $this->assertFalse($parser->match('Article(1)Article'));
        $this->assertFalse($parser->match('Article(1)Article(1)'));
    }
}
