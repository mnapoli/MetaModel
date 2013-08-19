<?php

namespace MetaModel\Bridge\PHPDI;

use MetaModel\DataSource\Container;

/**
 * Bridge to PHP-DI container
 */
class PHPDIBridge implements Container
{
    /**
     * @var \DI\Container
     */
    private $container;

    public function __construct(\DI\Container $container)
    {
        $this->container = $container;
    }

    /**
     * {@inheritdoc}
     */
    public function get($name)
    {
        return $this->container->get($name);
    }
}
