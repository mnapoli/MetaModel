<?php

namespace UnitTest\MetaModel\Parser;

use MetaModel\Model\AllInstancesSelector;
use MetaModel\Parser\AllInstancesSelectorParser;

class AllInstancesSelectorParserTest extends \PHPUnit_Framework_TestCase
{
    public function testParseSimpleSelector()
    {
        $parser = new AllInstancesSelectorParser();

        $selector = $parser->parse('Article(*)');

        $this->assertTrue($selector instanceof AllInstancesSelector);
        $this->assertEquals('Article', $selector->getName());
    }

    public function testParseNamespaceSelector()
    {
        $parser = new AllInstancesSelectorParser();

        $selector = $parser->parse('My\Article(*)');

        $this->assertTrue($selector instanceof AllInstancesSelector);
        $this->assertEquals('My\Article', $selector->getName());
    }

    public function testMatching()
    {
        $parser = new AllInstancesSelectorParser();

        $this->assertTrue($parser->match('Article(*)'));
        $this->assertTrue($parser->match('My\Article(*)'));
        $this->assertTrue($parser->match('My_Article(*)'));
    }

    public function testNotMatching()
    {
        $parser = new AllInstancesSelectorParser();

        $this->assertFalse($parser->match('Article'));
        $this->assertFalse($parser->match('Article()'));
        $this->assertFalse($parser->match('Article(1)'));
    }
}
