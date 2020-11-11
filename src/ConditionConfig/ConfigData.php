<?php
namespace ByteHello\ConditionBuilder\ConditionConfig;

class ConfigData
{
    protected $className;

    protected $classMethod;

    protected $options;

    public function __construct($className, $classMethod, $options = [])
    {
        $this->className = $className;
        $this->classMethod = $classMethod;
        $this->options = $options;
    }

    public function getClassName()
    {
        return $this->className;
    }

    public function getClassMethod()
    {
        return $this->classMethod;
    }

}