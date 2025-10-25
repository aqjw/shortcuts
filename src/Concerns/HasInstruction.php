<?php

namespace Aqjw\Shortcuts\Concerns;

use Closure;

trait HasInstruction
{
    protected string|Closure|null $instruction = null;

    public function instruction(string|Closure|null $instruction): static
    {
        $this->instruction = $instruction;

        return $this;
    }

    public function getInstruction(): ?string
    {
        return $this->evaluate($this->instruction);
    }
}
