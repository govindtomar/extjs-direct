<?php
/**
 * govindtomar/ext-direct
 *
 * @category   GT
 * @package    GT\ExtDirect
 * @copyright  Copyright (C) 2015 by TEQneers GmbH & Co. KG
 */

namespace GT\ExtDirect\Service;

use GT\ExtDirect\Metadata\ActionMetadata;

/**
 * Interface ServiceRegistry
 *
 * @package GT\ExtDirect
 */
interface ServiceRegistry
{
    /**
     * @param string $service
     * @return ActionMetadata|null
     */
    public function getService($service);

    /**
     * @return ActionMetadata[]
     */
    public function getAllServices();
}
