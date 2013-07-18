<?php

namespace MetaModel\Parser;

use MetaModel\Parser\Model\NamedSelector;
use MetaModel\Parser\ParsingException;

/**
 * Named selector parser
 *
 * @author Matthieu Napoli <matthieu@mnapoli.fr>
 */
class NamedSelectorParser
{
    const PATTERN = '[\\\\_a-zA-Z0-9]+';

    /**
     * Parses an expression and returns a model
     *
     * @param string $expression
     *
     * @throws ParsingException
     * @return NamedSelector
     */
    public function parse($expression)
    {
        $matches = array();
        $result = preg_match('/^(' . self::PATTERN . ')$/', $expression, $matches);

        if ($result === 1) {
            $name = $matches[1];

            return new NamedSelector($name);
        }

        throw new ParsingException("Expression '$expression' not recognized");
	}

    public function match($expression)
    {
        $result = preg_match('/^' . self::PATTERN . '$/', $expression);

        return ($result === 1);
    }
}
