<?php
/**
 * govindtomar/ext-direct
 *
 * @category   GT
 * @package    GT\ExtDirect
 * @copyright  Copyright (C) 2015 by TEQneers GmbH & Co. KG
 */

namespace GT\ExtDirect\Router\Exception;


/**
 * Class StrictArgumentValidationException
 *
 * @package GT\ExtDirect\Router\Exception
 */
class StrictArgumentValidationException extends \RuntimeException
{
    /**
     */
    public function __construct()
    {
        parent::__construct('Strict argument validation failed: not all parameters could be validated');
    }
}
