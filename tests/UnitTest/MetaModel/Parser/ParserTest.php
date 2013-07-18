<?php

namespace UnitTest\MetaModel\Parser;

use MetaModel\Parser\Model\MethodCall;
use MetaModel\Parser\Model\PropertyAccess;
use MetaModel\Parser\Model\Selector;
use MetaModel\Parser\Parser;

class ParserTest extends \PHPUnit_Framework_TestCase
{
    public function testParseSelector()
    {
        $parser = Parser::create();

        /** @var Selector $ast */
        $ast = $parser->parse('Article(1)');

        $this->assertTrue($ast instanceof Selector);
        $this->assertEquals('Article', $ast->getName());
        $this->assertEquals(1, $ast->getId());
    }

    public function testParsePropertyAccess()
    {
        $parser = Parser::create();

        /** @var PropertyAccess $ast */
        $ast = $parser->parse('Article(1).id');

        $this->assertTrue($ast instanceof PropertyAccess);
        $this->assertEquals('id', $ast->getProperty());

        $selector = $ast->getSubNode();
        $this->assertTrue($selector instanceof Selector);
        $this->assertEquals('Article', $selector->getName());
        $this->assertEquals(1, $selector->getId());
    }

    public function testParseRecursivePropertyAccess()
    {
        $parser = Parser::create();

        /** @var PropertyAccess $ast */
        $ast = $parser->parse('Article(1).foo.bar');

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

    public function testParseMethodCall()
    {
        $parser = Parser::create();

        /** @var MethodCall $ast */
        $ast = $parser->parse('Article(1).getId()');

        $this->assertTrue($ast instanceof MethodCall);
        $this->assertEquals('getId', $ast->getMethod());

        $selector = $ast->getSubNode();
        $this->assertTrue($selector instanceof Selector);
        $this->assertEquals('Article', $selector->getName());
        $this->assertEquals(1, $selector->getId());
    }

    public function testParseRecursiveMethodCall()
    {
        $parser = Parser::create();

        /** @var MethodCall $ast */
        $ast = $parser->parse('Article(1).foo().bar()');

        $this->assertTrue($ast instanceof MethodCall);
        $this->assertEquals('bar', $ast->getMethod());

        /** @var MethodCall $subNode */
        $subNode = $ast->getSubNode();
        $this->assertTrue($subNode instanceof MethodCall);
        $this->assertEquals('foo', $subNode->getMethod());

        $subNode = $subNode->getSubNode();
        /** @var Selector $subNode */
        $this->assertTrue($subNode instanceof Selector);
        $this->assertEquals('Article', $subNode->getName());
        $this->assertEquals(1, $subNode->getId());
    }

    public function testParseMixedPropertyAccessMethodCalls1()
    {
        $parser = Parser::create();

        /** @var PropertyAccess $ast */
        $ast = $parser->parse('Article(1).foo().bar');

        $this->assertTrue($ast instanceof PropertyAccess);
        $this->assertEquals('bar', $ast->getProperty());

        /** @var MethodCall $subNode */
        $subNode = $ast->getSubNode();
        $this->assertTrue($subNode instanceof MethodCall);
        $this->assertEquals('foo', $subNode->getMethod());

        $subNode = $subNode->getSubNode();
        /** @var Selector $subNode */
        $this->assertTrue($subNode instanceof Selector);
        $this->assertEquals('Article', $subNode->getName());
        $this->assertEquals(1, $subNode->getId());
    }

    public function testParseMixedPropertyAccessMethodCalls2()
    {
        $parser = Parser::create();

        /** @var MethodCall $ast */
        $ast = $parser->parse('Article(1).foo.bar()');

        $this->assertTrue($ast instanceof MethodCall);
        $this->assertEquals('bar', $ast->getMethod());

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
        $parser = Parser::create();
        $parser->parse('foo.bar');
    }

    /**
     * @test
     * @expectedException \JMS\Parser\SyntaxErrorException
     * @expectedExceptionMessage Expected end of input, but got "Article(2)"
     */
    public function selectorShouldNotBeNested()
    {
        $parser = Parser::create();
        $parser->parse('Article(1).Article(2)');
    }
}
