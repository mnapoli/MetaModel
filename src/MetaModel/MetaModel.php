<?php

namespace MetaModel;

use JMS\Parser\SyntaxErrorException;
use MetaModel\DataSource\Container;
use MetaModel\DataSource\ObjectManager;
use MetaModel\Parser\Parser;
use MetaModel\Parser\ParsingException;

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
     * @var Container[]
     */
    private $containers = [];

    /**
     * @var Parser
     */
    private $parser;

    public function __construct(Parser $parser = null)
    {
        $this->parser = $parser ?: Parser::create();
    }

    /**
     * Run a MetaModel expression
     * @param string $expression
     * @throws ParsingException
     * @return mixed
     */
    public function run($expression)
    {
        // Parses the expression
        try {
            $ast = $this->parser->parse($expression);
        } catch (SyntaxErrorException $e) {
            throw new ParsingException($e->getMessage(), 0, $e);
        }

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

    /**
     * @param Container $container
     */
    public function addContainer(Container $container)
    {
        $this->containers[] = $container;
    }

    /**
     * @return Container[]
     */
    public function getContainers()
    {
        return $this->containers;
    }
}
