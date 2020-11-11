<?php

use ByteHello\ConditionBuilder\Builder;
use ByteHello\ConditionBuilder\Condition\AndConditionGroup;
use ByteHello\ConditionBuilder\Condition\OrConditionGroup;
use ByteHello\ConditionBuilder\ConditionConfig\ConfigData;

require 'vendor/autoload.php';

$orConditionGroup = new OrConditionGroup();
$orConditionGroup->addMultiple(
    [
        new ConfigData('Test', 'orCheck'),
        new ConfigData('Test', 'orChec2'),
    ]
);

$conditionGroup = new AndConditionGroup();
$conditionGroup->addMultiple([
    new ConfigData('Test', 'check'),
    new ConfigData('Test', 'check2'),
]);

$conditionGroup->add($orConditionGroup);

$codeObj = Builder::generateCode($conditionGroup);
$node = $codeObj->getExpr();
$stmts = [$node];
$prettyPrinter = new \PhpParser\PrettyPrinter\Standard();
echo $prettyPrinter->prettyPrint($stmts);
echo PHP_EOL;