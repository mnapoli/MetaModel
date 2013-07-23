<?php

namespace MetaModel\Parser;

use MetaModel\Model\AllInstancesSelector;
use MetaModel\Parser\ParsingException;

/**
 * "All instances" selector parser
 *
 * @author Matthieu Napoli <matthieu@mnapoli.fr>
 */
class AllInstancesSelectorParser
{
    const PATTERN_CLASS = '[\\\\_a-zA-Z0-9]+';

    /**
     * Parses an expression and returns a model
     *
     * @param string $expression
     *
     * @throws ParsingException
     * @return AllInstancesSelector
     */
    public function parse($expression)
    {
        $matches = array();
        $result = preg_match('/^(' . self::PATTERN_CLASS . ')\\(\\*\\)$/', $expression, $matches);

        if ($result === 1) {
            $className = $matches[1];

            return new AllInstancesSelector($className);
        }

        throw new ParsingException("Expression '$expression' not recognized");
	}

    public function match($expression)
    {
        $result = preg_match('/^' . self::PATTERN_CLASS . '\\(\\*\\)$/', $expression);

        return ($result === 1);
    }
}
