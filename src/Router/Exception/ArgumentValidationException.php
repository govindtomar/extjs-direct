<?php
/**
 * govindtomar/ext-direct
 *
 * @category   GT
 * @package    GT\ExtDirect
 * @copyright  Copyright (C) 2015 by TEQneers GmbH & Co. KG
 */

namespace GT\ExtDirect\Router\Exception;

use Symfony\Component\Validator\ConstraintViolationInterface;
use GT\ExtDirect\Router\ArgumentValidationResult;


/**
 * Class ArgumentValidationException
 *
 * @package GT\ExtDirect\Router\Exception
 */
class ArgumentValidationException extends \InvalidArgumentException
{
    /**
     * @var ArgumentValidationResult
     */
    private $result;

    /**
     * @var bool
     */
    private $strictFailure;

    /**
     * @param ArgumentValidationResult $result
     * @param bool                     $strictFailure
     */
    public function __construct(ArgumentValidationResult $result, $strictFailure)
    {
        $this->result        = $result;
        $this->strictFailure = $strictFailure;
        $violationsInfo      = array();
        foreach ($this->getViolations() as $parameter => $violation) {
            /** @var ConstraintViolationInterface $violation */

            if ($violation->getPropertyPath() !== '') {
                $key = $parameter . '/' . $violation->getPropertyPath();
            } else {
                $key = $parameter;
            }
            $violationsInfo[$key][] = sprintf('%s [%s]', $violation->getMessage(), $violation->getCode());
        }

        parent::__construct('Argument validation failed: ' . json_encode($violationsInfo));
    }

    /**
     * @return bool
     */
    public function isStrictFailure()
    {
        return $this->strictFailure;
    }

    /**
     * @return \Generator
     */
    public function getViolations()
    {
        foreach ($this->result as $parameter => $violations) {
            /** @var ConstraintViolationInterface $violation */
            foreach ($violations as $violation) {
                yield $parameter => $violation;
            }
        }
    }

    /**
     * @return ArgumentValidationResult
     */
    public function getResult()
    {
        return $this->result;
    }
}
