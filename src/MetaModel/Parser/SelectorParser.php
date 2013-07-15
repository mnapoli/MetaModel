<?php

namespace MetaModel\Parser;

use MetaModel\Parser\ParsingException;
use MetaModel\Parser\Model\Selector;

/**
 * SelectorParser
 *
 * @author Matthieu Napoli <matthieu@mnapoli.fr>
 */
class SelectorParser
{
    const PATTERN_CLASS = '[\\a-zA-Z0-9]+';
    const PATTERN_ID = '[0-9]+';

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
        $result = preg_match('/^(' . self::PATTERN_CLASS . ')\((' . self::PATTERN_ID . ')\)$/', $expression, $matches);

        if ($result === 1) {
            $className = $matches[1];
            $id = $matches[2];

            return Selector::createSelectorById($className, $id);
        }

        throw new ParsingException("Expression '$expression' not recognized");
	}
}
