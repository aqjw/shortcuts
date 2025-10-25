<?php

namespace Aqjw\Shortcuts\Concerns;

use Closure;

trait HasTimeout
{
    protected int|Closure $timeout = 700; // ms

    public function timeout(int|Closure $value): static
    {
        $this->timeout = $value;

        return $this;
    }

    public function getTimeout(): int
    {
        return $this->evaluate($this->timeout);
    }
}
