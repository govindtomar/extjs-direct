<?php
/**
 * Created by PhpStorm.
 * User: stefan
 * Date: 23.07.15
 * Time: 15:00
 */

namespace GT\ExtDirect\Tests\Description;

use PHPUnit\Framework\TestCase;
use GT\ExtDirect\Description\ActionDescription;
use GT\ExtDirect\Description\MethodDescription;

/**
 * Class ActionDescriptionTest
 *
 * @package GT\ExtDirect\Tests\Description
 */
class ActionDescriptionTest extends TestCase
{
    public function testActionWithoutMethods()
    {
        $a = new ActionDescription('action');
        $this->assertEquals('action', $a->getName());
        $this->assertEmpty($a->getMethods());
    }

    public function testActionWithTwoMethods()
    {
        $a1 = new MethodDescription('method1');
        $a2 = new MethodDescription('method2');
        $a  = new ActionDescription('action', array($a1, $a2));
        $this->assertEquals('action', $a->getName());
        $this->assertCount(2, $a->getMethods());
    }

    public function testAddMethod()
    {
        $a = new ActionDescription('action', array(new MethodDescription('method1')));
        $a->addMethod(new MethodDescription('method2'));
        $this->assertCount(2, $a->getMethods());
    }

    public function testAddMethods()
    {
        $a = new ActionDescription('action', array(new MethodDescription('method1')));
        $a->addMethods(array(new MethodDescription('method2'), new MethodDescription('method3')));
        $this->assertCount(3, $a->getMethods());
    }

    public function testSetMethods()
    {
        $a = new ActionDescription('action', array(new MethodDescription('method1')));
        $a->setMethods(array(new MethodDescription('method2'), new MethodDescription('method3')));
        $this->assertCount(2, $a->getMethods());
    }
}
