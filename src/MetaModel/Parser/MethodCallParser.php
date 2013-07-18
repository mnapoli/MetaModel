<?php

namespace MetaModel\Parser;

use MetaModel\Parser\Model\MethodCall;
use MetaModel\Parser\ParsingException;

/**
 * Method call parser
 *
 * @author Matthieu Napoli <matthieu@mnapoli.fr>
 */
class MethodCallParser
{
    const PATTERN_NAME = '[_a-zA-Z0-9]+';
    const PATTERN_PARAMETERS = '\\(\\)';

    /**
     * Parses an expression and returns a model
     *
     * @param string $expression
     *
     * @throws ParsingException
     * @return MethodCall
     */
    public function parse($expression)
    {
        $matches = array();
        $result = preg_match('/^\\.(' . self::PATTERN_NAME . ')' . self::PATTERN_PARAMETERS . '$/', $expression, $matches);

        if ($result === 1) {
            $method = $matches[1];

            $methodCall = new MethodCall();
            $methodCall->setMethod($method);
            return $methodCall;
        }

        throw new ParsingException("Expression '$expression' not recognized");
	}

    public function match($expression)
    {
        $result = preg_match('/^\\.' . self::PATTERN_NAME . self::PATTERN_PARAMETERS . '$/', $expression);

        return ($result === 1);
    }
}
