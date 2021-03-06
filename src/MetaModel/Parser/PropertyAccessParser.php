<?php

namespace MetaModel\Parser;

use MetaModel\Model\PropertyAccess;
use MetaModel\Parser\ParsingException;

/**
 * Property access parser
 *
 * @author Matthieu Napoli <matthieu@mnapoli.fr>
 */
class PropertyAccessParser
{
    const PATTERN_NAME = '[_a-zA-Z0-9]+';

    /**
     * Parses an expression and returns a model
     *
     * @param string $expression
     *
     * @throws ParsingException
     * @return PropertyAccess
     */
    public function parse($expression)
    {
        $matches = array();
        $result = preg_match('/^\\.(' . self::PATTERN_NAME . ')$/', $expression, $matches);

        if ($result === 1) {
            $property = $matches[1];

            $propertyAccess = new PropertyAccess();
            $propertyAccess->setProperty($property);
            return $propertyAccess;
        }

        throw new ParsingException("Expression '$expression' not recognized");
	}

    public function match($expression)
    {
        $result = preg_match('/^\\.' . self::PATTERN_NAME . '$/', $expression, $matches);

        return ($result === 1);
    }
}
