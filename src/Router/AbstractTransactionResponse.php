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
 * Class AbstractTransactionResponse
 *
 * @package GT\ExtDirect
 */
abstract class AbstractTransactionResponse extends Response
{
    /**
     * @var int
     */
    private $tid;

    /**
     * @var string
     */
    private $action;

    /**
     * @var string
     */
    private $method;

    /**
     * Constructor
     *
     * @param string  $type
     * @param integer $tid
     * @param string  $action
     * @param string  $method
     */
    public function __construct($type, $tid, $action, $method)
    {
        parent::__construct($type);
        $this->tid    = $tid;
        $this->action = $action;
        $this->method = $method;
    }

    /**
     * @return int
     */
    public function getTid()
    {
        return $this->tid;
    }

    /**
     * @return string
     */
    public function getAction()
    {
        return $this->action;
    }

    /**
     * @return string
     */
    public function getMethod()
    {
        return $this->method;
    }

    public function jsonSerialize(): mixed
    {
        return array_merge(
            parent::jsonSerialize(),
            array(
                'tid'    => $this->getTid(),
                'action' => $this->getAction(),
                'method' => $this->getMethod(),
            )
        );
    }
}
