<?php

namespace Aqjw\Shortcuts;

use Aqjw\Shortcuts\Concerns\HasCombinations;
use Aqjw\Shortcuts\Concerns\HasInstruction;
use Aqjw\Shortcuts\Concerns\HasTimeout;
use Aqjw\Shortcuts\StateCasts\ShortcutStateCast;
use Filament\Forms\Components\Concerns\HasAffixes;
use Filament\Forms\Components\Concerns\HasPlaceholder;
use Filament\Forms\Components\Field;
use Filament\Support\Concerns\HasColor;
use Filament\Support\Concerns\HasExtraAlpineAttributes;

class ShortcutInput extends Field
{
    use HasAffixes;
    use HasColor;
    use HasCombinations;
    use HasExtraAlpineAttributes;
    use HasInstruction;
    use HasPlaceholder;
    use HasTimeout;

    protected string $view = 'shortcuts::shortcut-input';

    protected function setUp(): void
    {
        parent::setUp();

        $this->placeholder(__('shortcuts::shortcuts.placeholder'));
        $this->instruction(__('shortcuts::shortcuts.instruction'));
    }

    public function getDefaultStateCasts(): array
    {
        return [
            ...parent::getDefaultStateCasts(),
            app(ShortcutStateCast::class),
        ];
    }
}
