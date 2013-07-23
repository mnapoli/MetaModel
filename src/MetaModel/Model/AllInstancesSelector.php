<?php

namespace MetaModel\Model;

use MetaModel\MetaModel;

/**
 * "All instances" selector
 *
 * @author Matthieu Napoli <matthieu@mnapoli.fr>
 */
class AllInstancesSelector implements Node
{
    /**
     * Class name
     * @var string
     */
    private $name;

    /**
     * @param string $name
     */
    public function __construct($name)
    {
        $this->name = $name;
    }

    /**
     * {@inheritdoc}
     */
    public function execute(MetaModel $metaModel)
    {
        foreach ($metaModel->getObjectManagers() as $objectManager) {
            $result = $objectManager->getAllByName($this->name);

            if ($result !== null) {
                return $result;
            }
        }

        return [];
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
}
