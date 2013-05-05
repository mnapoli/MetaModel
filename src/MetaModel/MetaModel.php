<?php

namespace MetaModel;

use Doctrine\ORM\EntityManager;
use MetaModel\MML\AST\RootSelector;
use MetaModel\MML\Parser;

class MetaModel
{

    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * MML Parser
     * @var Parser
     */
    private $parser;

    public function __construct()
    {
        $this->parser = new Parser();
    }

    /**
     * @param string $query
     * @return mixed
     */
    public function get($query)
    {
        $ast = $this->parser->parse($query);

        if ($ast instanceof RootSelector) {
            return $ast->execute($this->entityManager)->unwrap();
        }

        return null;
    }

    /**
     * @return EntityManager
     */
    public function getEntityManager()
    {
        return $this->entityManager;
    }

    /**
     * @param EntityManager $entityManager
     */
    public function setEntityManager(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

}
