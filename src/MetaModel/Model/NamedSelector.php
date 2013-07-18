<?php

namespace MetaModel\Model;

use MetaModel\MetaModel;

/**
 * Named selector
 *
 * @author Matthieu Napoli <matthieu@mnapoli.fr>
 */
class NamedSelector implements Node
{
    /**
     * Entry name
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
        foreach ($metaModel->getContainers() as $container) {
            $result = $container->get($this->name);

            if ($result !== null) {
                return $result;
            }
        }

        return null;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
}
