<?php
/**
 * govindtomar/ext-direct
 *
 * @category   GT
 * @package    GT\ExtDirect
 * @copyright  Copyright (C) 2015 by TEQneers GmbH & Co. KG
 */

namespace GT\ExtDirect\Annotation;


/**
 * Class Method
 *
 * @package GT\ExtDirect\Annotation
 *
 * @Annotation
 * @Target("METHOD")
 */
class Method
{
    /**
     * @var bool
     */
    public $formHandler = false;

    /**
     * @var bool
     */
    public $namedParams = false;

    /**
     * @var bool
     */
    public $strict = true;

    /**
     * @var mixed
     */
    public $batched = null;

    /**
     * @var bool
     */
    public $session = true;
}
