<?php

namespace UnitTest\MetaModel\Parser;

use MetaModel\Model\MethodCall;
use MetaModel\Model\NamedSelector;
use MetaModel\Model\PropertyAccess;
use MetaModel\Model\IdSelector;
use MetaModel\Parser\Parser;

class ParserTest extends \PHPUnit_Framework_TestCase
{
    public function testParseIdSelector()
    {
        $parser = Parser::create();

        /** @var \MetaModel\Model\IdSelector $ast */
        $ast = $parser->parse('Article(1)');

        $this->assertTrue($ast instanceof IdSelector);
        $this->assertEquals('Article', $ast->getName());
        $this->assertEquals(1, $ast->getId());
    }

    public function testParseNamedSelector()
    {
        $parser = Parser::create();

        /** @var NamedSelector $ast */
        $ast = $parser->parse('ArticleService');

        $this->assertTrue($ast instanceof NamedSelector);
        $this->assertEquals('ArticleService', $ast->getName());
    }

    public function testParsePropertyAccess()
    {
        $parser = Parser::create();

        /** @var \MetaModel\Model\PropertyAccess $ast */
        $ast = $parser->parse('Article(1).id');

        $this->assertTrue($ast instanceof PropertyAccess);
        $this->assertEquals('id', $ast->getProperty());

        $selector = $ast->getSubNode();
        $this->assertTrue($selector instanceof IdSelector);
        $this->assertEquals('Article', $selector->getName());
        $this->assertEquals(1, $selector->getId());
    }

    public function testParseRecursivePropertyAccess()
    {
        $parser = Parser::create();

        /** @var \MetaModel\Model\PropertyAccess $ast */
        $ast = $parser->parse('Article(1).foo.bar');

        $this->assertTrue($ast instanceof PropertyAccess);
        $this->assertEquals('bar', $ast->getProperty());

        /** @var PropertyAccess $subNode */
        $subNode = $ast->getSubNode();
        $this->assertTrue($subNode instanceof PropertyAccess);
        $this->assertEquals('foo', $subNode->getProperty());

        $subNode = $subNode->getSubNode();
        /** @var \MetaModel\Model\IdSelector $subNode */
        $this->assertTrue($subNode instanceof IdSelector);
        $this->assertEquals('Article', $subNode->getName());
        $this->assertEquals(1, $subNode->getId());
    }

    public function testParseMethodCall()
    {
        $parser = Parser::create();

        /** @var \MetaModel\Model\MethodCall $ast */
        $ast = $parser->parse('Article(1).getId()');

        $this->assertTrue($ast instanceof MethodCall);
        $this->assertEquals('getId', $ast->getMethod());

        $selector = $ast->getSubNode();
        $this->assertTrue($selector instanceof IdSelector);
        $this->assertEquals('Article', $selector->getName());
        $this->assertEquals(1, $selector->getId());
    }

    public function testParseRecursiveMethodCall()
    {
        $parser = Parser::create();

        /** @var \MetaModel\Model\MethodCall $ast */
        $ast = $parser->parse('Article(1).foo().bar()');

        $this->assertTrue($ast instanceof MethodCall);
        $this->assertEquals('bar', $ast->getMethod());

        /** @var \MetaModel\Model\MethodCall $subNode */
        $subNode = $ast->getSubNode();
        $this->assertTrue($subNode instanceof MethodCall);
        $this->assertEquals('foo', $subNode->getMethod());

        $subNode = $subNode->getSubNode();
        /** @var IdSelector $subNode */
        $this->assertTrue($subNode instanceof IdSelector);
        $this->assertEquals('Article', $subNode->getName());
        $this->assertEquals(1, $subNode->getId());
    }

    public function testParseMixedPropertyAccessMethodCalls1()
    {
        $parser = Parser::create();

        /** @var \MetaModel\Model\PropertyAccess $ast */
        $ast = $parser->parse('Article(1).foo().bar');

        $this->assertTrue($ast instanceof PropertyAccess);
        $this->assertEquals('bar', $ast->getProperty());

        /** @var MethodCall $subNode */
        $subNode = $ast->getSubNode();
        $this->assertTrue($subNode instanceof MethodCall);
        $this->assertEquals('foo', $subNode->getMethod());

        $subNode = $subNode->getSubNode();
        /** @var IdSelector $subNode */
        $this->assertTrue($subNode instanceof IdSelector);
        $this->assertEquals('Article', $subNode->getName());
        $this->assertEquals(1, $subNode->getId());
    }

    public function testParseMixedPropertyAccessMethodCalls2()
    {
        $parser = Parser::create();

        /** @var \MetaModel\Model\MethodCall $ast */
        $ast = $parser->parse('Article(1).foo.bar()');

        $this->assertTrue($ast instanceof MethodCall);
        $this->assertEquals('bar', $ast->getMethod());

        /** @var PropertyAccess $subNode */
        $subNode = $ast->getSubNode();
        $this->assertTrue($subNode instanceof PropertyAccess);
        $this->assertEquals('foo', $subNode->getProperty());

        $subNode = $subNode->getSubNode();
        /** @var IdSelector $subNode */
        $this->assertTrue($subNode instanceof IdSelector);
        $this->assertEquals('Article', $subNode->getName());
        $this->assertEquals(1, $subNode->getId());
    }

    /**
     * @test
     * @expectedException \JMS\Parser\SyntaxErrorException
     */
    public function firstItemShouldBeASelector()
    {
        $parser = Parser::create();
        $parser->parse('foo().bar');
    }

    /**
     * @test
     * @expectedException \JMS\Parser\SyntaxErrorException
     */
    public function selectorShouldNotBeNested()
    {
        $parser = Parser::create();
        $parser->parse('Article(1).Article(2)');
    }
}
