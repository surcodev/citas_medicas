<div x-data="{
    open: {{ $active ? 'true' : 'false' }}
    }">
    <button type="button" class="flex items-center w-full p-2 text-base text-gray-900 transition duration-75 rounded-lg group hover:bg-gray-100"
        @click="open = !open">
    <span class="w-6 h-6 inline-flex justify-center items-center text-gray-500">
        <i class="{{ $icon }}"></i>
    </span>
                                    <div class="flex items-center justify-between w-full">
                                        <span class="ms-3 text-left rtl:text-right whitespace-nowrap">
                                            {{ $name }}
                                        </span>
                                        <i :class="{
                                            'fa-solid fa-chevron-up': open,
                                            'fa-solid fa-chevron-down': !open
                                        }"></i>
                                    </div>
                                </button>
                                <ul x-show="open" x-cloak class="py-2 space-y-2">
                                    @foreach ($items as $item)
                                        <li class="pl-4">        
                                        {!! $item->render() !!}
                                        </li>
                                    @endforeach
                                </ul>
</div>