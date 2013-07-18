<?php

namespace UnitTest\MetaModel\Parser;

use MetaModel\Parser\Model\NamedSelector;
use MetaModel\Parser\NamedSelectorParser;

class NamedSelectorParserTest extends \PHPUnit_Framework_TestCase
{
    public function testParseSimpleNamedSelector()
    {
        $parser = new NamedSelectorParser();

        $this->assertTrue($parser->match('ArticleService'));

        $selector = $parser->parse('ArticleService');

        $this->assertTrue($selector instanceof NamedSelector);
        $this->assertEquals('ArticleService', $selector->getName());
    }

    public function testParseNamespaceIdSelector()
    {
        $parser = new NamedSelectorParser();

        $this->assertTrue($parser->match('My\ArticleService'));

        $selector = $parser->parse('My\ArticleService');

        $this->assertTrue($selector instanceof NamedSelector);
        $this->assertEquals('My\ArticleService', $selector->getName());
    }

    public function testMatching()
    {
        $parser = new NamedSelectorParser();

        $this->assertTrue($parser->match('ArticleService'));
        $this->assertTrue($parser->match('My\ArticleService'));
        $this->assertTrue($parser->match('My_ArticleService'));
    }

    public function testNotMatching()
    {
        $parser = new NamedSelectorParser();

        $this->assertFalse($parser->match('Article()'));
        $this->assertFalse($parser->match('Article(1)'));
    }
}
