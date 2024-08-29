<?php
/**
 * Created by PhpStorm.
 * User: stefan
 * Date: 22.01.16
 * Time: 10:18
 */

namespace GT\ExtDirect\Annotation;

/**
 * Class Security
 *
 * @package GT\ExtDirect\Annotation
 *
 * @Annotation
 * @Target({"CLASS","METHOD"})
 */
class Security
{
    /**
     * @\Doctrine\Common\Annotations\Annotation\Required
     *
     * @var string
     */
    public $expression;
}
