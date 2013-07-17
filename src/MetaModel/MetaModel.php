<?php

namespace MetaModel;

use MetaModel\Parser\Model\PropertyAccess;
use MetaModel\Parser\Model\Selector;
use MetaModel\Parser\Parser;

/**
 * MetaModel
 *
 * @author Matthieu Napoli <matthieu@mnapoli.fr>
 */
class MetaModel
{
    /**
     * @var ObjectManager[]
     */
    private $objectManagers = [];

    /**
     * @var Parser
     */
    private $parser;

    public function __construct(Parser $parser = null)
    {
        $this->parser = $parser ?: Parser::create();
    }

    /**
     * @param string $query
     * @return mixed
     */
    public function run($query)
    {
        // Parses the expression
        $ast = $this->parser->parse($query);

        return $ast->execute($this);
    }

    /**
     * @param ObjectManager $objectManager
     */
    public function addObjectManager(ObjectManager $objectManager)
    {
        $this->objectManagers[] = $objectManager;
    }

    /**
     * @return ObjectManager[]
     */
    public function getObjectManagers()
    {
        return $this->objectManagers;
    }
}
