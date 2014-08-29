<?php

namespace Aztech\Closure;

use Jeremeamia\SuperClosure\ClosureParser;
use Jeremeamia\SuperClosure\SerializableClosure;

class MergeableClosure extends SerializableClosure
{
    public function getState()
    {
        if (! $this->state) {
            $this->createState();
        }

        return $this->state[1];
    }

    public function reconcileScope(MergeableClosure $scopeProvider)
    {
        $selfReflection = new \ReflectionFunction($this->getClosure());
        $selfLocals = $selfReflection->getStaticVariables();

        $otherReflection = new \ReflectionFunction($scopeProvider->getClosure());
        $otherLocals = $otherReflection->getStaticVariables();

        $parser = new ClosureParser($this->getReflection());

        foreach ($parser->getClosureAbstractSyntaxTree()->uses as $use) {
            if ($use->byRef) {
                $localVar = $selfLocals[$use->var];
                $selfLocals[$use->var] = $otherLocals[$use->var];
            }
        }
    }
}
