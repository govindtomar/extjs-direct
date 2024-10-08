<?php
/**
 * govindtomar/extjs-direct
 *
 * @category   GT
 * @package    GT\ExtDirect
 * @copyright  Copyright (C) 2015 by TEQneers GmbH & Co. KG
 */

namespace GT\ExtDirect\Router;

use Symfony\Component\Validator\Validator\ValidatorInterface;
use GT\ExtDirect\Router\Exception\ArgumentValidationException;
use GT\ExtDirect\Router\Exception\StrictArgumentValidationException;

/**
 * Class ArgumentValidator
 *
 * @package GT\ExtDirect\Router
 */
class ArgumentValidator implements ArgumentValidatorInterface
{
    /**
     * @var ValidatorInterface
     */
    private $validator;

    /**
     * @var bool
     */
    private $strict = true;

    /**
     * @param ValidatorInterface $validator
     * @param bool               $strict
     */
    public function __construct(ValidatorInterface $validator, $strict = true)
    {
        $this->setValidator($validator);
        $this->setStrict($strict);
    }

    /**
     * {@inheritdoc}
     */
    public function validate(ServiceReference $service, array $arguments)
    {
        $validationResult = array();
        $parameterCount   = 0;
        $validatedCount   = 0;
        $hasStrictFailure = false;
        foreach ($arguments as $name => $value) {
            if (strpos($name, '__internal__') !== false) {
                continue;
            }

            $constraints        = $service->getParameterConstraints($name);
            $validationGroups   = $service->getParameterValidationGroups($name);
            $isStrictValidation = $service->isStrictParameterValidation($name);
            if (!empty($constraints)) {
                $violations = $this->validator->validate($value, $constraints, $validationGroups);
                if (count($violations)) {
                    $validationResult[$name] = $violations;
                    if ($isStrictValidation) {
                        $hasStrictFailure = true;
                    }
                }
                $validatedCount++;
            }
            $parameterCount++;
        }

        if ($this->strict && ($parameterCount !== $validatedCount)) {
            throw new StrictArgumentValidationException();
        }

        if (!empty($validationResult)) {
            throw new ArgumentValidationException(new ArgumentValidationResult($validationResult), $hasStrictFailure);
        }
    }

    /**
     * @return ValidatorInterface
     */
    public function getValidator()
    {
        return $this->validator;
    }

    /**
     * @param ValidatorInterface $validator
     * @return $this
     */
    public function setValidator(ValidatorInterface $validator)
    {
        $this->validator = $validator;
        return $this;
    }

    /**
     * @return bool
     */
    public function isStrict()
    {
        return $this->strict;
    }

    /**
     * @param bool $strict
     * @return $this
     */
    public function setStrict($strict)
    {
        $this->strict = (bool)$strict;
        return $this;
    }
}
