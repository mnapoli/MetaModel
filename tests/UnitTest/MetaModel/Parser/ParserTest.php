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

        $selector = $ast->getSubNode();
        $this->assertTrue($selector instanceof Selector);
        $this->assertEquals('Article', $selector->getName());
        $this->assertEquals(1, $selector->getId());
    }

    public function testParseRecursivePropertyAccess()
    {
        $selectorParser = Parser::create();

        /** @var PropertyAccess $ast */
        $ast = $selectorParser->parse('Article(1).foo.bar');

        $this->assertTrue($ast instanceof PropertyAccess);
        $this->assertEquals('bar', $ast->getProperty());

        /** @var PropertyAccess $subNode */
        $subNode = $ast->getSubNode();
        $this->assertTrue($subNode instanceof PropertyAccess);
        $this->assertEquals('foo', $subNode->getProperty());

        $subNode = $subNode->getSubNode();
        /** @var Selector $subNode */
        $this->assertTrue($subNode instanceof Selector);
        $this->assertEquals('Article', $subNode->getName());
        $this->assertEquals(1, $subNode->getId());
    }

    /**
     * @test
     * @expectedException \MetaModel\Parser\ParsingException
     * @expectedExceptionMessage First item of the expression should be a selector
     */
    public function firstItemShouldBeASelector()
    {
        $selectorParser = Parser::create();
        $selectorParser->parse('foo.bar');
    }

    /**
     * @test
     * @expectedException \MetaModel\Parser\ParsingException
     * @expectedExceptionMessage Unexpected selector
     */
    public function selectorShouldNotBeNested()
    {
        $selectorParser = Parser::create();
        $selectorParser->parse('Article(1).Article(2)');
    }
}
