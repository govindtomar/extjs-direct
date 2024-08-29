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
 * Class ArgumentConverter
 *
 * @package GT\ExtDirect\Router
 */
interface ArgumentConverterInterface
{
    /**
     * @param ServiceReference $service
     * @param array            $arguments
     * @return array
     */
    public function convert(ServiceReference $service, array $arguments);
}
