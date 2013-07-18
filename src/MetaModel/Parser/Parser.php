<?php

namespace MetaModel\Parser;

use JMS\Parser\AbstractParser;
use JMS\Parser\SimpleLexer;
use MetaModel\Parser\Model\MethodCall;
use MetaModel\Parser\Model\Node;
use MetaModel\Parser\Model\PropertyAccess;
use MetaModel\Parser\Model\IdSelector;

/**
 * MetaModel expression parser
 *
 * @author Matthieu Napoli <matthieu@mnapoli.fr>
 */
class Parser extends AbstractParser
{
    const T_UNKNOWN = 0;
    const T_ID_SELECTOR = 1;
    const T_NAMED_SELECTOR = 2;
    const T_PROPERTY_ACCESS = 3;
    const T_METHOD_CALL = 4;

    /**
     * @return Parser
     */
    public static function create()
    {
        $idSelectorParser = new IdSelectorParser();
        $namedSelectorParser = new NamedSelectorParser();
        $propertyAccessParser = new PropertyAccessParser();
        $methodCallParser = new MethodCallParser();

        $lexer = new SimpleLexer(
            '/
                # ID selector
                ([\\\\_a-zA-Z0-9]+\([0-9]+\))

                # Named selector
                |([_a-zA-Z0-9]+)

                # Method call
                |(\\.[_a-zA-Z0-9]+\\(\\))

                # Property access
                |(\\.[_a-zA-Z0-9]+)
            /x', // The x modifier tells PCRE to ignore whitespace in the regex above.

            // This maps token types to a human readable name.
            array(
                 self::T_UNKNOWN => 'T_UNKNOWN',
                 self::T_ID_SELECTOR => 'T_ID_SELECTOR',
                 self::T_NAMED_SELECTOR => 'T_NAMED_SELECTOR',
                 self::T_METHOD_CALL => 'T_METHOD_CALL',
                 self::T_PROPERTY_ACCESS => 'T_PROPERTY_ACCESS',
            ),

            // This function tells the lexer which type a token has. The first element is
            // an integer from the map above, the second element the normalized value.
            function($part) use ($idSelectorParser, $namedSelectorParser, $propertyAccessParser, $methodCallParser) {
                if ($idSelectorParser->match($part)) {
                    return array(self::T_ID_SELECTOR, $part);
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
        $namedSelectorParser = new NamedSelectorParser();
        $propertyAccessParser = new PropertyAccessParser();
        $methodCallParser = new MethodCallParser();

        if (!$this->lexer->isNextAny([self::T_ID_SELECTOR, self::T_NAMED_SELECTOR])) {
            throw new ParsingException("First item of the expression should be a selector");
        }

        if ($this->lexer->isNext(self::T_ID_SELECTOR)) {
            $part = $this->match(self::T_ID_SELECTOR);
            /** @var Node $node */
            $node = $idSelectorParser->parse($part);
        } else {
            $part = $this->match(self::T_NAMED_SELECTOR);
            /** @var Node $node */
            $node = $namedSelectorParser->parse($part);
        }

        while ($this->lexer->isNextAny([self::T_PROPERTY_ACCESS, self::T_METHOD_CALL])) {
            if ($this->lexer->isNext(self::T_PROPERTY_ACCESS)) {
                $part = $this->match(self::T_PROPERTY_ACCESS);
                /** @var PropertyAccess $propertyAccess */
                $propertyAccess = $propertyAccessParser->parse($part);
                $propertyAccess->setSubNode($node);
                $node = $propertyAccess;
            } elseif ($this->lexer->isNext(self::T_METHOD_CALL)) {
                $part = $this->match(self::T_METHOD_CALL);
                /** @var MethodCall $methodCall */
                $methodCall = $methodCallParser->parse($part);
                $methodCall->setSubNode($node);
                $node = $methodCall;
            }
        }

        return $node;
    }
}
