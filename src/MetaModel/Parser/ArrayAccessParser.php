<?php

namespace MetaModel\Parser;

use MetaModel\Model\ArrayAccess;
use MetaModel\Parser\ParsingException;

/**
 * Array access parser
 *
 * @author Matthieu Napoli <matthieu@mnapoli.fr>
 */
class ArrayAccessParser
{
    const PATTERN_KEY = '[_a-zA-Z0-9]+';

    /**
     * Parses an expression and returns a model
     *
     * @param string $expression
     *
     * @throws ParsingException
     * @return ArrayAccess
     */
    public function parse($expression)
    {
        $matches = array();
        $result = preg_match('/^\\[(' . self::PATTERN_KEY . ')\\]$/', $expression, $matches);

        if ($result === 1) {
            $key = $matches[1];

            $arrayAccess = new ArrayAccess($key);
            return $arrayAccess;
        }

        throw new ParsingException("Expression '$expression' not recognized");
	}

    public function match($expression)
    {
        $result = preg_match('/^\\[' . self::PATTERN_KEY . '\\]$/', $expression, $matches);

        return ($result === 1);
    }
}
