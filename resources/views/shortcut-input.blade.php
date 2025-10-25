@php
    $id = $getId();
    $fieldWrapperView = $getFieldWrapperView();
    $extraAlpineAttributeBag = $getExtraAlpineAttributeBag();
    $statePath = $getStatePath();
    $placeholder = $getPlaceholder();
    $instruction = $getInstruction();
    $combinations = $getCombinations();
    $timeout = $getTimeout();
    $color = $getColor() ?? 'primary';
    $isDisabled = $isDisabled();
    $isPrefixInline = $isPrefixInline();
    $isSuffixInline = $isSuffixInline();
    $prefixActions = $getPrefixActions();
    $prefixIcon = $getPrefixIcon();
    $prefixIconColor = $getPrefixIconColor();
    $prefixLabel = $getPrefixLabel();
    $suffixActions = $getSuffixActions();
    $suffixIcon = $getSuffixIcon();
    $suffixIconColor = $getSuffixIconColor();
    $suffixLabel = $getSuffixLabel();
@endphp


<x-dynamic-component
    :component="$fieldWrapperView"
    :field="$field"
>
    <x-filament::input.wrapper
        :disabled="$isDisabled"
        :inline-prefix="$isPrefixInline"
        :inline-suffix="$isSuffixInline"
        :prefix="$prefixLabel"
        :prefix-actions="$prefixActions"
        :prefix-icon="$prefixIcon"
        :prefix-icon-color="$prefixIconColor"
        :suffix="$suffixLabel"
        :suffix-actions="$suffixActions"
        :suffix-icon="$suffixIcon"
        :suffix-icon-color="$suffixIconColor"
        :valid="!$errors->has($statePath)"
        :attributes="\Filament\Support\prepare_inherited_attributes($getExtraAttributeBag())->class([
            'fi-fo-select-has-inline-prefix' =>
                $isPrefixInline && (count($prefixActions) || $prefixIcon || filled($prefixLabel)),
        ])"
    >
        <div
            x-load
            x-load-src="{{ \Filament\Support\Facades\FilamentAsset::getAlpineComponentSrc('shortcuts', 'aqjw/shortcuts') }}"
            x-data="shortcutInputComponent({
                state: $wire.{{ $applyStateBindingModifiers("\$entangle('{$statePath}')") }},
                isDisabled: @js($isDisabled),
                combinations: @js($combinations),
                timeout: @js($timeout),
            })"
            x-bind="input"
            tabindex="0"
            class="px-3 py-1.5 flex items-center space-x-1 outline-none {{ $isDisabled ? '' : 'focus-within:animate-pulse' }}"
            {{ $extraAlpineAttributeBag }}
        >
            <template x-if="state.length === 0">
                <div class="py-0.5 text-gray-400 dark:text-gray-500">
                    <template x-if="isRecording">
                        <span class="animate-pulse">{{ $instruction }}</span>
                    </template>
                    <template x-if="!isRecording">
                        <span>{{ $placeholder }}</span>
                    </template>
                </div>
            </template>

            <template x-if="state.length > 0">
                <template
                    x-for="(key, index) in state"
                    x-bind:key="`${key}-${index}`"
                >
                    <x-filament::badge :color="$color">
                        <span x-text="key" class="uppercase"></span>
                    </x-filament::badge>
                </template>
            </template>
        </div>
    </x-filament::input.wrapper>
</x-dynamic-component>
