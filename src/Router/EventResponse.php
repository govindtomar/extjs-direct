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
 * Class EventResponse
 *
 * @package GT\ExtDirect
 */
class EventResponse extends Response
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var mixed
     */
    private $data;

    /**
     * Constructor
     *
     * @param string $name
     * @param mixed  $data
     */
    public function __construct($name, $data = null)
    {
        parent::__construct(self::TYPE_EVENT);
        $this->name = $name;
        $this->data = $data;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return mixed
     */
    public function getData()
    {
        return $this->data;
    }

    public function jsonSerialize(): mixed
    {
        return array_merge(
            parent::jsonSerialize(),
            array(
                'name' => $this->getName(),
                'data' => $this->getData()
            )
        );
    }
}
