<?php
namespace ByteHello\ConditionBuilder;

use Exception;

class Builder
{
    public static function generateCode($conditionGroup)
    {
        $node = $conditionGroup->getNode();
        if (!$node) {
            throw new ConditionBuilderException('node is null');
        }
        return $node;
    }
}