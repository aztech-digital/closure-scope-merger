<?php

namespace Aztech\Closure\Tests;

use Aztech\Closure\MergeableClosure;

class MergeableClosureTest extends \PHPUnit_Framework_TestCase
{

    public function testGetStateReturnsArrayWithStateVariables()
    {
        $refVar = false;
        $nonRefVar = false;

        $closure = new MergeableClosure(function() use (& $refVar, $nonRefVar) {
            $refVar = true;
            $nonRefVar = true;
        });

        $state = $closure->getState();

        $this->assertArrayHasKey('refVar', $state);
        $this->assertEquals($refVar, $state['refVar']);
        $this->assertArrayHasKey('nonRefVar', $state);
        $this->assertEquals($nonRefVar, $state['nonRefVar']);
    }

    public function testOnlyByRefUsesAreRestored()
    {
        $refVar = false;
        $nonRefVar = false;

        $closure = new MergeableClosure(function() use (& $refVar, $nonRefVar) {
            $refVar = true;
            $nonRefVar = true;
        });

        $scopeProvider = $this->executeInScope($closure);

        $this->assertFalse($refVar);
        $this->assertFalse($nonRefVar);

        $closure->reconcileScope($scopeProvider);

        $this->assertTrue($refVar);
        $this->assertFalse($nonRefVar);
    }

    private function executeInScope(MergeableClosure $closure)
    {
        $serialized = serialize($closure);
        $new = unserialize($serialized);

        $new();

        return $new;
    }
}
