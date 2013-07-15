<?php

namespace UnitTest\MetaModel\Parser;

use MetaModel\Parser\Model\Selector;
use MetaModel\Parser\SelectorParser;

class SelectorParserTest extends \PHPUnit_Framework_TestCase
{
    public function testParseSimpleSelector()
    {
        $selectorParser = new SelectorParser();

        $selector = $selectorParser->parse('Article(1)');

        $this->assertTrue($selector instanceof Selector);
        $this->assertEquals('Article', $selector->getName());
        $this->assertEquals(1, $selector->getId());
    }

    public function testParseNamespaceSelector()
    {
        $selectorParser = new SelectorParser();

        $selector = $selectorParser->parse('My\Article(1)');

        $this->assertTrue($selector instanceof Selector);
        $this->assertEquals('My\Article', $selector->getName());
        $this->assertEquals(1, $selector->getId());
    }
}
