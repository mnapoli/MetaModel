<?php

namespace MetaModel\Parser;

use JMS\Parser\AbstractParser;
use JMS\Parser\SimpleLexer;

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

    public static function create()
    {
        $selectorParser = new SelectorParser();
        $propertyParser = new PropertyParser();

        $lexer = new SimpleLexer(
            '/
                # ID selector
                ([\\a-zA-Z0-9]+\([0-9]+\))

                # Do not surround with () because . is not meaningful for our purpose
                |\.

                # Property
                |([a-zA-Z0-9]+)
            /x', // The x modifier tells PCRE to ignore whitespace in the regex above.

            // This maps token types to a human readable name.
            array(0 => 'T_UNKNOWN', 1 => 'T_SELECTOR', 2 => 'T_PROPERTY'),

            // This function tells the lexer which type a token has. The first element is
            // an integer from the map above, the second element the normalized value.
            function($part) use ($selectorParser, $propertyParser) {
                if ($selectorParser->match($part)) {
                    return array(1, $selectorParser->parse($part));
                }
                if ($propertyParser->match($part)) {
                    return array(2, $propertyParser->parse($part));
                }

                return array(0, $part);
            }
        );

        return new self($lexer);
    }

    /**
     * @return mixed
     */
    protected function parseInternal()
    {
        $result = $this->match(self::T_SELECTOR);

        while ($this->lexer->isNextAny(array(self::T_PROPERTY))) {
            if ($this->lexer->isNext(self::T_PROPERTY)) {
                $this->lexer->moveNext();
                $propertyFilter = $this->match(self::T_PROPERTY);
            } else {
                throw new \LogicException('Parsing error');
            }
        }

        return $result;
    }
}
