@props([
'label' => null,
'icon' => null,
'prepend' => null,
'append' => null,
'rows' => 3,
'size' => null,
'help' => null,
'model' => null,
'debounce' => false,
'lazy' => false,
'col'  => null,
])

{{--todo move dependencies to rapyd css/js at build/publish time--}}
@once
@push('rapyd_styles')
    <link rel="stylesheet" href="https://cdn.quilljs.com/1.3.6/quill.snow.css">
@endpush
@endonce
@once
@push('rapyd_scripts')
    <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
@endpush
@endonce

@php

    if ($debounce) $bind = '.live.debounce.' . (ctype_digit($debounce) ? $debounce : 150) . 'ms';
    else if ($lazy) $bind = '.lazy';
    else $bind = '';
    $wireModel = $attributes->whereStartsWith('wire:model')->first();
    $key = $attributes->get('name', $model ?? $wireModel);
    $id = $attributes->get('id', $model ?? $wireModel);
    $prefix = null;
    $attributes = $attributes->class([])->merge([
        'id' => $id,
        'rows' => $rows,
        'wire:model' . $bind => $model ? $prefix . $model : null,
    ]);
@endphp


<div class="{{$col}}" wire:ignore >
    <x-rpd::label :for="$id" :label="$label"/>
    <div x-data
         x-init="
               quill = new Quill($refs.quillEditor, {theme: 'snow'});
               quill.on('text-change', function () {
                   $dispatch('quill-input', { key: quill.root.innerHTML });
               });
        "
        x-ref="quillEditor"
        x-on:quill-input.debounce.defer="@this.set('{{ $key }}', $event.detail)"
    >
        {!! dot_to_property($this, $key) !!}
    </div>
</div>


