<?php

namespace MetaModel\MML;

use MetaModel\MML\AST\RootSelector;

/**
 * MML (MetaModel Language) parser
 *
 * @author Matthieu Napoli <matthieu@mnapoli.fr>
 */
class Parser
{

    /**
     * Parses a MML expression and returns an AST
     *
     * @param string $expression
     *
     * @throws ParsingException
     * @return AST\RootSelector
     */
	public function parse($expression)
	{
        $matches = array();
        $result = preg_match('/^([\\a-zA-Z0-9]+)\(([a-zA-Z0-9]+|\*)\)$/', $expression, $matches);

        if ($result === 1) {
            $className = $matches[1];
            $id = $matches[2];
            if ($id === '*') {
                return new RootSelector($className);
            } else {
                return new RootSelector($className, $id);
            }
        }

        throw new ParsingException("Expression '$expression' not recognized");
	}

}
