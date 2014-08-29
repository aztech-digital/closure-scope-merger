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

        $this->assertArrayHasKey('refVar', $state, 'Ref var should be present in state.');
        $this->assertEquals($refVar, $state['refVar'], 'Ref var should have initial value.');
        $this->assertArrayHasKey('nonRefVar', $state, 'Non ref var should be present in state.');
        $this->assertEquals($nonRefVar, $state['nonRefVar'], 'Non ref var should have initial value.');
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

        $this->assertFalse($refVar, 'Ref var should have initial value.');
        $this->assertFalse($nonRefVar, 'Non ref var should have initial value.');

        $closure->reconcileScope($scopeProvider);

        $this->assertTrue($refVar, 'Ref var should have updated value.');
        $this->assertFalse($nonRefVar, 'Non ref var should have initial value.');
    }

    public function testReflectionFunctionRefVars()
    {
        $refVariable = false;
        $refName = 'refVariable';
        
        $callback = function() use (& $refVariable)
        {
            $refVariable = true;
        };
        
        $function = new \ReflectionFunction($callback);
        $staticVariables = $function->getStaticVariables();
        
        $this->assertTrue(array_key_exists($refName, $staticVariables));
        $this->assertTrue($refVariable === false);
        
        $staticVariables[$refName] = true;
        
        $this->assertTrue($refVariable === true);
    }
    
    private function executeInScope(MergeableClosure $closure)
    {
        $serialized = serialize($closure);
        $new = unserialize($serialized);

        $new();

        return $new;
    }
    
    public function testRefAssignments()
    {
        $test = false;
        $var = array('test' => & $test);
        
        $this->refFunc($var);
        
        $this->assertTrue($test);
    }
    
    public function refFunc(& $var)
    {
        $var['test'] = true;
    }
}
