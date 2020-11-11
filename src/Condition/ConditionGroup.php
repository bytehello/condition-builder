<?php
namespace ByteHello\ConditionBuilder\Condition;

use ByteHello\ConditionBuilder\Code;
use ByteHello\ConditionBuilder\ConditionConfig\ConfigData;
use PhpParser\BuilderFactory;
use PhpParser\Node\Expr;
use PhpParser\Node\Expr\BinaryOp\BooleanAnd;
use PhpParser\Node\Expr\BinaryOp\BooleanOr;

abstract class ConditionGroup
{
    const OPERATOR_AND = 'and';
    const OPERATOR_OR = 'or';
    public $operator;
    public $expectValue;
    public $parts = [];
    public $error = '';

    protected $factor;

    public function __construct()
    {
        $factor = new BuilderFactory;
        $this->factor = $factor;

    }
    public function addMultiple($args)
    {
        foreach ($args as $arg) {
            $this->add($arg);
        }
    }

    public function add($arg)
    {
        if ($arg instanceof ConditionGroup || $arg instanceof ConfigData) {
            $this->parts[] = $arg;
            return true;
        }
        return false;
    }

    public function getNode()
    {
        $results = [];
        foreach ($this->parts as $part) {
            if ($part instanceof self) {
                $results[] = $part->getNode();
            } else {
                try {
                    $results[] = new Expr\MethodCall($this->factor->new($part->getClassName()), $part->getClassMethod());
                } catch (\Exception $exception) {
                    echo $exception->getMessage();
                }
            }
        }


        $node = $this->buildExpr($results);
        return $node;
    }

    protected function buildExpr($results)
    {
        if (!count($results)) {
            return null;
        }
        if (count($results) === 1) {
            return $results[0];
        } elseif (count($results) === 2) {
            $node = $this->getBinaryOperatorNode($results[0], $results[1]);
            return $node;
        }
        array_shift($results);
        return $this->getBinaryOperatorNode($results[0], $this->buildExpr($results));
    }

    protected function getBinaryOperatorNode($left, $right)
    {
        if ($this->operator == 'and') {
            return new BooleanAnd($left, $right);
        } elseif ($this->operator == 'or') {
            return new BooleanOr($left, $right);
        }
    }

}
