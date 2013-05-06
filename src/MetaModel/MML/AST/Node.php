<?php

namespace MetaModel\MML\AST;

use Doctrine\ORM\EntityManager;
use MetaModel\MML\Result\ObjectCollection;
use MetaModel\MML\Result\SingleObject;

/**
 * AST Node
 *
 * @author Matthieu Napoli <matthieu@mnapoli.fr>
 */
abstract class Node
{

    /**
     * @param EntityManager $entityManager
     * @return ObjectCollection|SingleObject
     */
    public abstract function execute(EntityManager $entityManager);

}
