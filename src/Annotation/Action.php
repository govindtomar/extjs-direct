<?php
/**
 * govindtomar/extjs-direct
 *
 * @category   GT
 * @package    GT\ExtDirect
 * @copyright  Copyright (C) 2015 by TEQneers GmbH & Co. KG
 */

namespace GT\ExtDirect\Annotation;


/**
 * Class Action
 *
 * @package GT\ExtDirect\Annotation
 *
 * @Annotation
 * @Target("CLASS")
 */
class Action
{
    /**
     * @var string
     */
    public $serviceId;

    /**
     * @var string
     */
    public $alias;
}
