<?php

namespace Aqjw\Shortcuts\StateCasts;

use Filament\Schemas\Components\StateCasts\Contracts\StateCast;

class ShortcutStateCast implements StateCast
{
    /**
     * @return array<mixed, mixed>
     */
    public function get(mixed $state): array
    {
        if (blank($state)) {
            return [];
        }

        if (! is_array($state)) {
            $state = json_decode($state, associative: true);
        }

        return (array) $state;
    }

    /**
     * @return array<array{key: mixed, value: mixed}>
     */
    public function set(mixed $state): array
    {
        if (blank($state)) {
            return [];
        }

        if (! is_array($state)) {
            $state = json_decode($state, associative: true);
        }

        return (array) $state;
    }
}
