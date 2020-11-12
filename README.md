# Introduction

condition-builder is a library help you build condition code snippet like
```
(new Test())->check1() && (new Test())->check2()
```

# Install

```

composer require bytehello/condition-builder

```

# Usage

```
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
$stmts = [$node];
$prettyPrinter = new \PhpParser\PrettyPrinter\Standard();
echo $prettyPrinter->prettyPrint($stmts);
echo PHP_EOL;

```

output is

```

(new Test())->check4() && ((new Test())->check5() && ((new Test())->check3() || (new Test())->check1() && (new Test())->check2()))

```

# License

The bytehello/condition-builder is open-source software licensed under the MIT license.