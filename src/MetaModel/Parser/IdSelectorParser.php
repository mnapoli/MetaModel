<?php

namespace MetaModel\Parser;

use MetaModel\Parser\ParsingException;
use MetaModel\Model\IdSelector;

/**
 * ID selector parser
 *
 * @author Matthieu Napoli <matthieu@mnapoli.fr>
 */
class IdSelectorParser
{
    const PATTERN_CLASS = '[\\\\_a-zA-Z0-9]+';
    const PATTERN_ID = '[0-9]+';

    /**
     * Parses an expression and returns a model
     *
     * @param string $expression
     *
     * @throws ParsingException
     * @return \MetaModel\Model\IdSelector
     */
    public function parse($expression)
    {
        $matches = array();
        $result = preg_match('/^(' . self::PATTERN_CLASS . ')\((' . self::PATTERN_ID . ')\)$/', $expression, $matches);

        if ($result === 1) {
            $className = $matches[1];
            $id = $matches[2];

            return new IdSelector($className, $id);
        }

        throw new ParsingException("Expression '$expression' not recognized");
	}

    public function match($expression)
    {
        $result = preg_match('/^' . self::PATTERN_CLASS . '\(' . self::PATTERN_ID . '\)$/', $expression);

        return ($result === 1);
    }
}
