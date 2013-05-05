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
            if ($ast->hasId()) {
                return $this->entityManager->find($ast->getClassName(), $ast->getId());
            } else {
                $qb = $this->entityManager->createQueryBuilder();
                $qb->select('class');
                $qb->from($ast->getClassName(), 'class');
                return $qb->getQuery()->getResult();
            }
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
