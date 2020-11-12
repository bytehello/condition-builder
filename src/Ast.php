<?php
namespace ByteHello\ConditionBuilder;
use PhpParser\BuilderFactory;
use PhpParser\Node\Expr;
use PhpParser\Node\Expr\BinaryOp\BooleanAnd;
use PhpParser\Node\Expr\BinaryOp\BooleanOr;

class Ast
{
    public function __construct()
    {
        $this->factor = new BuilderFactory;
    }


    public function buildExpr($data)
    {
        return new Expr\MethodCall($this->factor->new($data->getClassName()), $data->getClassMethod());
    }

    public function buildConditionCode($operator, $results)
    {
        if (!count($results)) {
            return null;
        }
        if (count($results) === 1) {
            return $results[0];
        } elseif (count($results) === 2) {
            $node = $this->getBinaryOperatorNode($operator, $results[0], $results[1]);
            return $node;
        }
        $firstResult = $results[0];
        array_shift($results);
        $leftResult = $results;
        return $this->getBinaryOperatorNode($operator, $firstResult, $this->buildConditionCode($operator, $leftResult));
    }

    protected function getBinaryOperatorNode($operator, $left, $right)
    {
        if ($operator == 'and') {
            return new BooleanAnd($left, $right);
        } elseif ($operator == 'or') {
            return new BooleanOr($left, $right);
        }
    }
}