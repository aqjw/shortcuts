<?php

namespace Aqjw\Shortcuts\Concerns;

use Closure;

trait HasCombinations
{
    protected int|Closure $combinations = 1;

    public function combinations(int|Closure $combinations): static
    {
        $this->combinations = $combinations;

        return $this;
    }

    public function getCombinations(): int
    {
        return $this->evaluate($this->combinations);
    }
}
