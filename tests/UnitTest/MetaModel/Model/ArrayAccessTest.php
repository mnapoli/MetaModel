<?php

namespace UnitTest\MetaModel\Parser;

use MetaModel\MetaModel;
use MetaModel\Model\ArrayAccess;

class ArrayAccessTest extends \PHPUnit_Framework_TestCase
{
    public function testAccessIntKey()
    {
        $metaModel = $this->getMockForAbstractClass('MetaModel\MetaModel');

        $subNode = $this->getMockForAbstractClass('MetaModel\Model\Node');
        $subNode->expects($this->once())
            ->method('execute')
            ->will($this->returnValue([0 => 'bar']));

        $arrayAccess = new ArrayAccess(0);
        $arrayAccess->setSubNode($subNode);

        $this->assertEquals('bar', $arrayAccess->execute($metaModel));
    }

    public function testAccessStringKey()
    {
        /** @var MetaModel $metaModel */
        $metaModel = $this->getMockForAbstractClass('MetaModel\MetaModel');

        $subNode = $this->getMockForAbstractClass('MetaModel\Model\Node');
        $subNode->expects($this->once())
            ->method('execute')
            ->will($this->returnValue(['foo' => 'bar']));

        $arrayAccess = new ArrayAccess('foo');
        $arrayAccess->setSubNode($subNode);

        $this->assertEquals('bar', $arrayAccess->execute($metaModel));
    }

    public function testAccessUnknownKey()
    {
        /** @var MetaModel $metaModel */
        $metaModel = $this->getMockForAbstractClass('MetaModel\MetaModel');

        $subNode = $this->getMockForAbstractClass('MetaModel\Model\Node');
        $subNode->expects($this->once())
            ->method('execute')
            ->will($this->returnValue([]));

        $arrayAccess = new ArrayAccess('foo');
        $arrayAccess->setSubNode($subNode);

        $this->assertNull($arrayAccess->execute($metaModel));
    }

    /**
     * @expectedException \MetaModel\ExecutionException
     * @expectedExceptionMessage Array access is impossible on a variable that is not an array, or implementing \ArrayAccess
     */
    public function testNotArray()
    {
        /** @var MetaModel $metaModel */
        $metaModel = $this->getMockForAbstractClass('MetaModel\MetaModel');

        $subNode = $this->getMockForAbstractClass('MetaModel\Model\Node');
        $subNode->expects($this->once())
            ->method('execute')
            ->will($this->returnValue('some string'));

        $arrayAccess = new ArrayAccess('foo');
        $arrayAccess->setSubNode($subNode);

        $arrayAccess->execute($metaModel);
    }
}
