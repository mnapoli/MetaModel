<?php

namespace MetaModel\Parser;

use MetaModel\Parser\ParsingException;
use MetaModel\Parser\Model\Selector;

/**
 * Property parser
 *
 * @author Matthieu Napoli <matthieu@mnapoli.fr>
 */
class PropertyParser
{
    const PATTERN = '[a-zA-Z0-9]+';

    /**
     * Parses an expression and returns a model
     *
     * @param string $expression
     *
     * @throws ParsingException
     * @return Selector
     */
    public function parse($expression)
    {
        $matches = array();
        $result = preg_match('/^(' . self::PATTERN . ')$/', $expression, $matches);

        if ($result === 1) {
            $property = $matches[1];
            // TODO
        }

        throw new ParsingException("Expression '$expression' not recognized");
	}

    public function match($expression)
    {
        $result = preg_match('/^(' . self::PATTERN . ')$/', $expression, $matches);

        return ($result === 1);
    }
}
