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
 * Class RequestCollection
 *
 * @package GT\ExtDirect
 */
class RequestCollection implements \IteratorAggregate, \Countable, \JsonSerializable
{
    /**
     * @var Request[]
     */
    private $requests;

    /**
     * @param Request[] $requests
     */
    public function __construct(array $requests)
    {
        $this->requests = $requests;
    }

    /**
     * @return Request[]
     */
    public function all()
    {
        return $this->requests;
    }

    /**
     * @return Request|null
     */
    public function getFirst()
    {
        if (count($this->requests) > 0) {
            return reset($this->requests);
        } else {
            return null;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getIterator(): \Traversable
    {
        return new \ArrayIterator($this->requests);
    }

    /**
     * {@inheritdoc}
     */
    public function count(): int
    {
        return count($this->requests);
    }

    /**
     * @return boolean
     */
    public function isForm()
    {
        $firstRequest = $this->getFirst();
        if (!$firstRequest) {
            return false;
        }
        return $firstRequest->isForm();
    }

    /**
     * @return boolean
     */
    public function isUpload()
    {
        $firstRequest = $this->getFirst();
        if (!$firstRequest || !$firstRequest) {
            return false;
        }
        return $firstRequest->isUpload();
    }

    /**
     * @return boolean
     */
    public function isFormUpload()
    {
        return $this->isForm() && $this->isUpload();
    }

    public function jsonSerialize(): mixed
    {
        if (count($this->requests) !== 1) {
            return $this->requests;
        }

        return reset($this->requests);
    }
}
