<?php
namespace ByteHello\ConditionBuilder\Condition;

use ByteHello\ConditionBuilder\Ast;
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

    protected $ast;

    public function __construct()
    {
        $this->ast = new Ast();
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
                    $results[] = $this->ast->buildExpr($part);
                } catch (\Exception $exception) {
                    echo $exception->getMessage();
                }
            }
        }
        
        $node = $this->ast->buildConditionCode($this->operator, $results);
        return $node;
    }


}
