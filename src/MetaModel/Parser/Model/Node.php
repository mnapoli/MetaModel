<?php

namespace MetaModel\Parser\Model;

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
     * @return Node|mixed
     */
    public function execute(MetaModel $metaModel);
}
