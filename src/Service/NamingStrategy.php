<?php
/**
 * govindtomar/extjs-direct
 *
 * @category   GT
 * @package    GT\ExtDirect
 * @copyright  Copyright (C) 2015 by TEQneers GmbH & Co. KG
 */

namespace GT\ExtDirect\Service;

/**
 * Interface NamingStrategy
 *
 * @package GT\ExtDirect\Service
 */
interface NamingStrategy
{
    /**
     * @param $className
     * @return string
     */
    public function convertToActionName($className);
}
