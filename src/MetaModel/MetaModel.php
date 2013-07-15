<?php

namespace MetaModel;

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
        $this->parser = $parser ?: new Parser();
    }

    /**
     * @param string $query
     * @return mixed
     */
    public function run($query)
    {
        // Parses the expression
        $ast = $this->parser->parse($query);

        if ($ast instanceof Selector) {
            foreach ($this->objectManagers as $objectManager) {
                $result = $objectManager->getById($ast->getName(), $ast->getId());

                if ($result !== null) {
                    return $result;
                }
            }
        }

        return null;
    }

    /**
     * @param ObjectManager $objectManager
     */
    public function addObjectManager(ObjectManager $objectManager)
    {
        $this->objectManagers[] = $objectManager;
    }
}
