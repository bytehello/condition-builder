<?php

use ByteHello\ConditionBuilder\Builder;
use ByteHello\ConditionBuilder\Condition\AndConditionGroup;
use ByteHello\ConditionBuilder\Condition\OrConditionGroup;
use ByteHello\ConditionBuilder\ConditionConfig\ConfigData;

require 'vendor/autoload.php';

$andConditionG1 = new AndConditionGroup();
$andConditionG1->addMultiple(
    [
        new ConfigData('Test', 'check1'),
        new ConfigData('Test', 'check2'),
    ]
);

$orConditionG1 = new OrConditionGroup();
$orConditionG1->addMultiple(
    [
        new ConfigData('Test', 'check3'),
        $andConditionG1
    ]
);

$andConditionG2 = new AndConditionGroup();
$andConditionG2->addMultiple([
    new ConfigData('Test', 'check4'),
    new ConfigData('Test', 'check5'),
    $orConditionG1
]);

$node = Builder::generateCode($andConditionG2);
echo Builder::getPrintedStatements($node);
echo PHP_EOL;