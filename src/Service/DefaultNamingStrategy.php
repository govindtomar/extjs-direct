<?php
/**
 * govindtomar/ext-direct
 *
 * @category   GT
 * @package    GT\ExtDirect
 * @copyright  Copyright (C) 2015 by TEQneers GmbH & Co. KG
 */

namespace GT\ExtDirect\Service;

/**
 * Class DefaultNamingStrategy
 *
 * @package GT\ExtDirect\Service
 */
class DefaultNamingStrategy implements NamingStrategy
{
    /**
     * {@inheritdoc}
     */
    public function convertToActionName($className)
    {
        return str_replace('\\', '.', $className);
    }
}
