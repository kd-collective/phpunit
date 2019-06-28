--TEST--
\PHPUnit\Framework\MockObject\Generator::generate('Foo', [], 'MockFoo', true)
--FILE--
<?php declare(strict_types=1);
interface IFoo
{
    public function __construct($bar);
}

class Foo implements IFoo
{
    public function __construct($bar)
    {
    }
}

require __DIR__ . '/../../../../vendor/autoload.php';

$generator = new \PHPUnit\Framework\MockObject\Generator;

$mock = $generator->generate(
    'Foo',
    [],
    'MockFoo',
    true
);

print $mock->getClassCode();
--EXPECTF--
declare(strict_types=1);

class MockFoo extends Foo implements PHPUnit\Framework\MockObject\MockObject
{
    use \PHPUnit\Framework\MockObject\ConfigurableMethods;
    use \PHPUnit\Framework\MockObject\OriginalObject;
    use \PHPUnit\Framework\MockObject\ReturnValueGeneration;

    private $__phpunit_invocationMocker;

    public function __clone()
    {
        $this->__phpunit_invocationMocker = clone $this->__phpunit_getInvocationMocker();
    }

    public function expects(\PHPUnit\Framework\MockObject\Matcher\Invocation $matcher): \PHPUnit\Framework\MockObject\Builder\InvocationMocker
    {
        return $this->__phpunit_getInvocationMocker()->expects($matcher);
    }

    public function method()
    {
        $any     = new \PHPUnit\Framework\MockObject\Matcher\AnyInvokedCount;
        $expects = $this->expects($any);

        return call_user_func_array([$expects, 'method'], func_get_args());
    }

    public function __phpunit_getInvocationMocker(): \PHPUnit\Framework\MockObject\InvocationMocker
    {
        if ($this->__phpunit_invocationMocker === null) {
            $this->__phpunit_invocationMocker = new \PHPUnit\Framework\MockObject\InvocationMocker(static::$__phpunit_configurableMethods, $this->__phpunit_returnValueGeneration);
        }

        return $this->__phpunit_invocationMocker;
    }

    public function __phpunit_hasMatchers(): bool
    {
        return $this->__phpunit_getInvocationMocker()->hasMatchers();
    }

    public function __phpunit_verify(bool $unsetInvocationMocker = true): void
    {
        $this->__phpunit_getInvocationMocker()->verify();

        if ($unsetInvocationMocker) {
            $this->__phpunit_invocationMocker = null;
        }
    }
}
