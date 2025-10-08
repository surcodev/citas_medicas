@props(['tab' => 'default'])

<div x-show="tab === '{{ $tab }}'" x-cloak>
    {{ $slot }}
</div>