<?php

namespace UnitTest\MetaModel\Parser;

use MetaModel\Parser\Model\Selector;
use MetaModel\Parser\Parser;

class ParserTest extends \PHPUnit_Framework_TestCase
{
    public function testParseCorrectSelector()
    {
        $selectorParser = Parser::create();

        $selector = $selectorParser->parse('Article(1)');

        $this->assertTrue($selector instanceof Selector);
        $this->assertEquals('Article', $selector->getName());
        $this->assertEquals(1, $selector->getId());
    }
}
