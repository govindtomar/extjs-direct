<?php
/**
 * govindtomar/extjs-direct
 *
 * @category   GT
 * @package    GT\ExtDirect
 * @copyright  Copyright (C) 2015 by TEQneers GmbH & Co. KG
 */

use Doctrine\Common\Annotations\AnnotationRegistry;

$loader = require __DIR__ . '/../vendor/autoload.php';

AnnotationRegistry::registerLoader(array($loader, 'loadClass'));
