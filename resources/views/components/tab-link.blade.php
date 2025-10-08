@props(['tab' => 'default'])

<li class="me-2">
    <a
        href="#"
        x-on:click.prevent="tab = '{{ $tab }}'"
        :class="{
            'inline-flex items-center justify-center p-4 text-blue-600 border-b-2 border-blue-600 rounded-t-lg dark:text-blue-500 dark:border-blue-500': tab === '{{ $tab }}',
            'inline-flex items-center justify-center p-4 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300': tab !== '{{ $tab }}'
        }"
    >
        {{ $slot }}
    </a>
</li>
