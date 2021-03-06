<?php

namespace MetaModel\Parser;

use JMS\Parser\AbstractParser;
use JMS\Parser\SimpleLexer;
use MetaModel\Model\ArrayAccess;
use MetaModel\Model\MethodCall;
use MetaModel\Model\Node;
use MetaModel\Model\PropertyAccess;
use MetaModel\Model\IdSelector;

/**
 * MetaModel expression parser
 *
 * @author Matthieu Napoli <matthieu@mnapoli.fr>
 */
class Parser extends AbstractParser
{
    const T_UNKNOWN = 0;
    const T_ID_SELECTOR = 1;
    const T_ALL_INSTANCES_SELECTOR = 2;
    const T_NAMED_SELECTOR = 3;
    const T_PROPERTY_ACCESS = 4;
    const T_METHOD_CALL = 5;
    const T_ARRAY_ACCESS = 6;

    /**
     * @return Parser
     */
    public static function create()
    {
        $idSelectorParser = new IdSelectorParser();
        $allInstancesSelectorParser = new AllInstancesSelectorParser();
        $namedSelectorParser = new NamedSelectorParser();
        $propertyAccessParser = new PropertyAccessParser();
        $arrayAccessParser = new ArrayAccessParser();
        $methodCallParser = new MethodCallParser();

        $lexer = new SimpleLexer(
            '/
                # ID selector
                ([\\\\_a-zA-Z0-9]+\([0-9]+\))

                # All instances selector
                |([\\\\_a-zA-Z0-9]+\\(\\*\\))

                # Named selector
                |([\\\\_a-zA-Z0-9]+)

                # Method call
                |(\\.[_a-zA-Z0-9]+\\(\\))

                # Property access
                |(\\.[_a-zA-Z0-9]+)

                # Array access
                |(\\[[_a-zA-Z0-9]+\\])
            /x', // The x modifier tells PCRE to ignore whitespace in the regex above.

            // This maps token types to a human readable name.
            array(
                 self::T_UNKNOWN => 'T_UNKNOWN',
                 self::T_ID_SELECTOR => 'T_ID_SELECTOR',
                 self::T_ALL_INSTANCES_SELECTOR => 'T_ALL_INSTANCES_SELECTOR',
                 self::T_NAMED_SELECTOR => 'T_NAMED_SELECTOR',
                 self::T_METHOD_CALL => 'T_METHOD_CALL',
                 self::T_PROPERTY_ACCESS => 'T_PROPERTY_ACCESS',
                 self::T_ARRAY_ACCESS => 'T_ARRAY_ACCESS',
            ),

            // This function tells the lexer which type a token has. The first element is
            // an integer from the map above, the second element the normalized value.
            function($part) use ($idSelectorParser, $allInstancesSelectorParser, $namedSelectorParser, $propertyAccessParser, $methodCallParser, $arrayAccessParser) {
                if ($idSelectorParser->match($part)) {
                    return array(self::T_ID_SELECTOR, $part);
                }
                if ($allInstancesSelectorParser->match($part)) {
                    return array(self::T_ALL_INSTANCES_SELECTOR, $part);
                }
                if ($namedSelectorParser->match($part)) {
                    return array(self::T_NAMED_SELECTOR, $part);
                }
                if ($methodCallParser->match($part)) {
                    return array(self::T_METHOD_CALL, $part);
                }
                if ($propertyAccessParser->match($part)) {
                    return array(self::T_PROPERTY_ACCESS, $part);
                }
                if ($arrayAccessParser->match($part)) {
                    return array(self::T_ARRAY_ACCESS, $part);
                }

                return array(self::T_UNKNOWN, $part);
            }
        );

        return new self($lexer);
    }

    /**
     *
     * @throws ParsingException
     * @return Node
     */
    protected function parseInternal()
    {
        $idSelectorParser = new IdSelectorParser();
        $allInstancesSelectorParser = new AllInstancesSelectorParser();
        $namedSelectorParser = new NamedSelectorParser();
        $propertyAccessParser = new PropertyAccessParser();
        $arrayAccessParser = new ArrayAccessParser();
        $methodCallParser = new MethodCallParser();

        if (!$this->lexer->isNextAny([self::T_ID_SELECTOR, self::T_ALL_INSTANCES_SELECTOR, self::T_NAMED_SELECTOR])) {
            throw new ParsingException("First item of the expression should be a selector");
        }

        // First item is a selector
        if ($this->lexer->isNext(self::T_ID_SELECTOR)) {
            $part = $this->match(self::T_ID_SELECTOR);
            /** @var Node $node */
            $node = $idSelectorParser->parse($part);
        } elseif ($this->lexer->isNext(self::T_ALL_INSTANCES_SELECTOR)) {
            $part = $this->match(self::T_ALL_INSTANCES_SELECTOR);
            /** @var Node $node */
            $node = $allInstancesSelectorParser->parse($part);
        } else {
            $part = $this->match(self::T_NAMED_SELECTOR);
            /** @var Node $node */
            $node = $namedSelectorParser->parse($part);
        }

        while ($this->lexer->isNextAny([self::T_PROPERTY_ACCESS, self::T_ARRAY_ACCESS, self::T_METHOD_CALL])) {

            if ($this->lexer->isNext(self::T_PROPERTY_ACCESS)) {
                $part = $this->match(self::T_PROPERTY_ACCESS);
                /** @var PropertyAccess $propertyAccess */
                $propertyAccess = $propertyAccessParser->parse($part);
                // Wraps around the current node
                $propertyAccess->setSubNode($node);
                $node = $propertyAccess;

            } elseif ($this->lexer->isNext(self::T_ARRAY_ACCESS)) {
                $part = $this->match(self::T_ARRAY_ACCESS);
                /** @var ArrayAccess $arrayAccess */
                $arrayAccess = $arrayAccessParser->parse($part);
                // Wraps around the current node
                $arrayAccess->setSubNode($node);
                $node = $arrayAccess;

            } elseif ($this->lexer->isNext(self::T_METHOD_CALL)) {
                $part = $this->match(self::T_METHOD_CALL);
                /** @var MethodCall $methodCall */
                $methodCall = $methodCallParser->parse($part);
                // Wraps around the current node
                $methodCall->setSubNode($node);
                $node = $methodCall;
            }
        }

        return $node;
    }
}
