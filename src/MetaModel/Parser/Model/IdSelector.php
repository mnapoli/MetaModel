<?php

namespace MetaModel\Parser\Model;

use MetaModel\MetaModel;

/**
 * ID selector
 *
 * @author Matthieu Napoli <matthieu@mnapoli.fr>
 */
class IdSelector implements Node
{
    /**
     * Class name
     * @var string
     */
    private $name;

    /**
     * ID selector
     * @var mixed|null
     */
    private $id;

    /**
     * @param string $class
     * @param mixed  $id
     */
    public function __construct($class, $id)
    {
        $this->name = $class;
        $this->id = $id;
    }

    /**
     * {@inheritdoc}
     */
    public function execute(MetaModel $metaModel)
    {
        foreach ($metaModel->getObjectManagers() as $objectManager) {
            $result = $objectManager->getById($this->name, $this->id);

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

    /**
     * @return mixed|null
     */
    public function getId()
    {
        return $this->id;
    }
}
