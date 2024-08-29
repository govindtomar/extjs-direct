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
 * Interface UserMessageExceptionInterface
 *
 * @package GT\ExtDirect\Router\Exception
 */
interface UserMessageExceptionInterface
{
    /**
     * @return string
     */
    public function getUserMessage();
}
