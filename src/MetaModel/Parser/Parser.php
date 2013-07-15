<?php

namespace MetaModel\Parser;

/**
 * MetaModel expression parser
 *
 * @author Matthieu Napoli <matthieu@mnapoli.fr>
 */
class Parser
{
    /**
     * Parses an expression and returns a model
     *
     * @param string $expression
     */
	public function parse($expression)
	{
        $selectorParser = new SelectorParser();

        return $selectorParser->parse($expression);
	}
}
