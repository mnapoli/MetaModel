<?php

namespace MetaModel\Model;

use MetaModel\MetaModel;

/**
 * Node interface
 *
 * @author Matthieu Napoli <matthieu@mnapoli.fr>
 */
interface Node
{
    /**
     * @param MetaModel $metaModel
     * @return \MetaModel\Model\Node|mixed
     */
    public function execute(MetaModel $metaModel);
}
