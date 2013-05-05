<?php
/**
 * PHP-DI
 *
 * @link      http://mnapoli.github.io/PHP-DI/
 * @copyright Matthieu Napoli (http://mnapoli.fr/)
 * @license   http://www.opensource.org/licenses/mit-license.php MIT (see the LICENSE file)
 */

namespace MetaModel\MML\AST;

class RootSelector
{

    /**
     * @var string
     */
    private $className;

    /**
     * @var mixed|null
     */
    private $id;

    /**
     * @param string     $className
     * @param mixed|null $id
     */
    public function __construct($className, $id = null)
    {
        $this->className = $className;
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getClassName()
    {
        return $this->className;
    }

    /**
     * @return bool
     */
    public function hasId()
    {
        return $this->id !== null;
    }

    /**
     * @return mixed|null
     */
    public function getId()
    {
        return $this->id;
    }

}
