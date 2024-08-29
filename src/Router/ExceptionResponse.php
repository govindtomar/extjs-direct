<?php
/**
 * govindtomar/ext-direct
 *
 * @category   GT
 * @package    GT\ExtDirect
 * @copyright  Copyright (C) 2015 by TEQneers GmbH & Co. KG
 */

namespace GT\ExtDirect\Router;

use GT\ExtDirect\Router\Exception\UserMessageExceptionInterface;

/**
 * Class ExceptionResponse
 *
 * @package GT\ExtDirect
 */
class ExceptionResponse extends AbstractTransactionResponse
{
    /**
     * @var \Exception
     */
    private $exception;

    /**
     * @var bool
     */
    private $debug;

    /**
     * @param Request    $request
     * @param \Exception $exception
     * @param bool       $debug
     * @return ExceptionResponse
     */
    public static function fromRequest(Request $request, \Exception $exception, $debug = false)
    {
        return new self(
            $request->getTid(),
            $request->getAction(),
            $request->getMethod(),
            $exception,
            $debug
        );
    }

    /**
     * Constructor
     *
     * @param integer    $tid
     * @param string     $action
     * @param string     $method
     * @param \Exception $exception
     * @param bool       $debug
     */
    public function __construct($tid, $action, $method, \Exception $exception, $debug = false)
    {
        parent::__construct(self::TYPE_EXCEPTION, $tid, $action, $method);

        $this->exception = $exception;
        $this->debug     = $debug;
    }

    /**
     * @return \Exception
     */
    public function getException()
    {
        return $this->exception;
    }

    /**
     * @return bool
     */
    public function isDebug()
    {
        return $this->debug;
    }

    public function jsonSerialize(): mixed
    {
        $exception = $this->getException();

        $where = '';
        if ($this->isDebug()) {
            $where = $exception->getTraceAsString();
        }

        $message = 'Internal Server Error';
        if ($this->isDebug()) {
            $message = $exception->getMessage();
        } elseif ($exception instanceof UserMessageExceptionInterface) {
            $message = $exception->getUserMessage();
        }

        return array_merge(
            parent::jsonSerialize(),
            array(
                'where'   => $where,
                'message' => $message,
                'code'    => $exception->getCode()
            )
        );
    }
}
