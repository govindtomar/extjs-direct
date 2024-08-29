<?php
/**
 * govindtomar/ext-direct
 *
 * @category   GT
 * @package    GT\ExtDirect
 * @copyright  Copyright (C) 2015 by TEQneers GmbH & Co. KG
 */

namespace GT\ExtDirect\Router;

/**
 * Interface ResultConverterInterface
 *
 * @package GT\ExtDirect\Router
 */
interface ResultConverterInterface
{
    /**
     * @param ServiceReference $service
     * @param mixed            $result
     * @return mixed
     */
    public function convert(ServiceReference $service, $result);
}
