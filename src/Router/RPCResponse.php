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
 * Class RpcResponse
 *
 * @package GT\ExtDirect
 */
class RPCResponse extends AbstractTransactionResponse
{
    /**
     * @var mixed
     */
    private $result;

    /**
     * @param Request $request
     * @param mixed   $result
     * @return RPCResponse
     */
    public static function fromRequest(Request $request, $result = null)
    {
        return new self(
            $request->getTid(),
            $request->getAction(),
            $request->getMethod(),
            $result
        );
    }

    /**
     * Constructor
     *
     * @param integer $tid
     * @param string  $action
     * @param string  $method
     * @param mixed   $result
     */
    public function __construct($tid, $action, $method, $result = null)
    {
        parent::__construct(self::TYPE_RPC, $tid, $action, $method);
        $this->result = $result;
    }

    /**
     * @return mixed
     */
    public function getResult()
    {
        return $this->result;
    }

    public function jsonSerialize(): mixed
    {
        return array_merge(
            parent::jsonSerialize(),
            array(
                'result' => $this->getResult()
            )
        );
    }
}
