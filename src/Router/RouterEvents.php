<?php
/**
 * govindtomar/extjs-direct
 *
 * @category   GT
 * @package    GT\ExtDirect
 * @copyright  Copyright (C) 2015 by TEQneers GmbH & Co. KG
 */

namespace GT\ExtDirect\Router;

/**
 * Class RouterEvents
 *
 * @package GT\ExtDirect\Router
 */
final class RouterEvents
{
    const BEGIN_REQUEST  = 'tq_extdirect.router.begin_request';
    const BEFORE_RESOLVE = 'tq_extdirect.router.before_resolve';
    const AFTER_RESOLVE  = 'tq_extdirect.router.after_resolve';
    const BEFORE_INVOKE  = 'tq_extdirect.router.before_invoke';
    const AFTER_INVOKE   = 'tq_extdirect.router.after_invoke';
    const EXCEPTION      = 'tq_extdirect.router.exception';
    const END_REQUEST    = 'tq_extdirect.router.end_request';
}
