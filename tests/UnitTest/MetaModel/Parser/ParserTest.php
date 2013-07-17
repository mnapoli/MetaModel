<?php

namespace UnitTest\MetaModel\Parser;

use MetaModel\Parser\Model\PropertyAccess;
use MetaModel\Parser\Model\Selector;
use MetaModel\Parser\Parser;

class ParserTest extends \PHPUnit_Framework_TestCase
{
    public function testParseSelector()
    {
        $selectorParser = Parser::create();

        /** @var Selector $ast */
        $ast = $selectorParser->parse('Article(1)');

        $this->assertTrue($ast instanceof Selector);
        $this->assertEquals('Article', $ast->getName());
        $this->assertEquals(1, $ast->getId());
    }

    public function testParsePropertyAccess()
    {
        $selectorParser = Parser::create();

        /** @var PropertyAccess $ast */
        $ast = $selectorParser->parse('Article(1).id');

        $this->assertTrue($ast instanceof PropertyAccess);
        $this->assertEquals('id', $ast->getProperty());

        $selector = $ast->getSelector();
        $this->assertTrue($selector instanceof Selector);
        $this->assertEquals('Article', $selector->getName());
        $this->assertEquals(1, $selector->getId());
    }
}
