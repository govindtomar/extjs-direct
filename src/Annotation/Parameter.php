<?php
/**
 * govindtomar/extjs-direct
 *
 * @category   GT
 * @package    GT\ExtDirect
 * @copyright  Copyright (C) 2015 by TEQneers GmbH & Co. KG
 */

namespace GT\ExtDirect\Annotation;

/**
 * Class Parameter
 *
 * @package GT\ExtDirect\Annotation
 *
 * @Annotation
 * @Target("METHOD")
 */
class Parameter
{
    /**
     * @\Doctrine\Common\Annotations\Annotation\Required
     *
     * @var string
     */
    public $name;

    /**
     * @var array<Symfony\Component\Validator\Constraint>
     */
    public $constraints = array();

    /**
     * @var array<string>
     */
    public $validationGroups;

    /**
     * @var bool
     */
    public $strict = true;

    /**
     * @var array<string>
     */
    public $serializationGroups = [];

    /**
     * @var array<string>
     */
    public $serializationAttributes = [];

    /**
     * @var int|null
     */
    public $serializationVersion = null;

    /**
     * @param array $data
     */
    public function __construct(array $data)
    {
        if (isset($data['value'])) {
            if (is_array($data['value'])) {
                $data['name'] = array_shift($data['value']);
                if (!empty($data['value'])) {
                    $data['constraints'] = array_shift($data['value']);
                }
                if (!empty($data['value'])) {
                    $data['validationGroups'] = array_shift($data['value']);
                }
                if (!empty($data['value'])) {
                    $data['strict'] = array_shift($data['value']);
                }
                if (!empty($data['value'])) {
                    $data['serializationGroups'] = array_shift($data['value']);
                }
                if (!empty($data['value'])) {
                    $data['serializationAttributes'] = array_shift($data['value']);
                }
                if (!empty($data['value'])) {
                    $data['serializationVersion'] = array_shift($data['value']);
                }
            } else {
                $data['name'] = $data['value'];
            }
            unset($data['value']);
        }

        foreach ($data as $k => $v) {
            if ($k == 'constraints' && !is_array($v)) {
                $v = array($v);
            } elseif ($k == 'validationGroups' && !is_array($v)) {
                $v = array($v);
            } elseif ($k == 'serializationGroups' && !is_array($v)) {
                $v = array($v);
            } elseif ($k == 'serializationAttributes' && !is_array($v)) {
                $v = array($v);
            }

            $this->{$k} = $v;
        }
    }
}
