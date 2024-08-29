<?php
/**
 * govindtomar/extjs-direct
 *
 * @category   GT
 * @package    GT\ExtDirect
 * @copyright  Copyright (C) 2015 by TEQneers GmbH & Co. KG
 */

namespace GT\ExtDirect\Service;

use GT\ExtDirect\Metadata\ActionMetadata;

/**
 * Interface ServiceFactory
 *
 * @package GT\ExtDirect
 */
interface ServiceFactory
{
    /**
     * @param ActionMetadata $metadata
     * @return object
     */
    public function createService(ActionMetadata $metadata);
}
