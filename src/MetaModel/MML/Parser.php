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
     * Parses MML code and returns an AST
     *
     * @param string $code
     *
     * @throws ParsingException
     * @return AST\RootSelector
     */
	public function parse($code)
	{
        $matches = array();
        $result = preg_match('/^([\\a-zA-Z0-9]+)\(([a-zA-Z0-9]+|\*)\)$/', $code, $matches);

        if ($result === 1) {
            $className = $matches[1];
            $id = $matches[2];
            if ($id === '*') {
                return new RootSelector($className);
            } else {
                return new RootSelector($className, $id);
            }
        }

        throw new ParsingException("Selector '$code' not recognized");
	}

}
