<?php
/**
 * Created by PhpStorm.
 * User: stefan
 * Date: 22.07.15
 * Time: 17:30
 */

namespace GT\ExtDirect\Tests\Metadata\Driver\Services;

use GT\ExtDirect\Annotation as Direct;

/**
 * Class Service12
 *
 * @package GT\ExtDirect\Tests\Metadata\Driver\Services
 *
 * @Direct\Action()
 */
class Service12
{
    /**
     * @Direct\Method(batched=null)
     */
    public function methodA()
    {
    }
    /**
     * @Direct\Method(batched=true)
     */
    public function methodB()
    {
    }

    /**
     * @Direct\Method(batched=false)
     */
    public function methodC()
    {
    }
}
