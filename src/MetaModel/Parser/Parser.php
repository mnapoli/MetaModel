<?php

namespace MetaModel\Parser;

use JMS\Parser\AbstractParser;
use JMS\Parser\SimpleLexer;
use MetaModel\Parser\Model\Node;
use MetaModel\Parser\Model\PropertyAccess;
use MetaModel\Parser\Model\Selector;

/**
 * MetaModel expression parser
 *
 * @author Matthieu Napoli <matthieu@mnapoli.fr>
 */
class Parser extends AbstractParser
{
    const T_UNKNOWN = 0;
    const T_SELECTOR = 1;
    const T_PROPERTY = 2;

    /**
     * @return Parser
     */
    public static function create()
    {
        $selectorParser = new SelectorParser();
        $propertyAccessParser = new PropertyAccessParser();

        $lexer = new SimpleLexer(
            '/
                # ID selector
                ([\\\\a-zA-Z0-9]+\([0-9]+\))

                # Do not surround with () because . is not meaningful for our purpose
                |\.

                # Property access
                |([a-zA-Z0-9]+)
            /x', // The x modifier tells PCRE to ignore whitespace in the regex above.

            // This maps token types to a human readable name.
            array(0 => 'T_UNKNOWN', 1 => 'T_SELECTOR', 2 => 'T_PROPERTY'),

            // This function tells the lexer which type a token has. The first element is
            // an integer from the map above, the second element the normalized value.
            function($part) use ($selectorParser, $propertyAccessParser) {
                if ($selectorParser->match($part)) {
                    return array(self::T_SELECTOR, $part);
                }
                if ($propertyAccessParser->match($part)) {
                    return array(self::T_PROPERTY, $part);
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
        $selectorParser = new SelectorParser();
        $propertyAccessParser = new PropertyAccessParser();

        if (!$this->lexer->isNext(self::T_SELECTOR)) {
            throw new ParsingException("First item of the expression should be a selector");
        }

        $part = $this->match(self::T_SELECTOR);
        /** @var Node $node */
        $node = $selectorParser->parse($part);

        while ($this->lexer->isNextAny(array(self::T_PROPERTY))) {
            if ($this->lexer->isNext(self::T_PROPERTY)) {
                $part = $this->match(self::T_PROPERTY);
                /** @var PropertyAccess $propertyAccess */
                $propertyAccess = $propertyAccessParser->parse($part);
                $propertyAccess->setSubNode($node);
                $node = $propertyAccess;
            }
        }

        return $node;
    }
}
