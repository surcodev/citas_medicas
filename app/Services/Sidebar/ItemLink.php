<?php

use App\Services\Sidebar\ItemSidebar;

class ItemLink implements ItemSidebar
{
    protected string $name;
    protected string $icon;
    protected string $href;
    protected bool $active;
    protected array $can;

    public function __construct(string $name, string $icon, string $href, bool $active, array $can)
    {
        $this->name = $name;
        $this->icon = $icon;
        $this->href = $href;
        $this->active = $active;
        $this->can = $can;
    }

    public function render(): string
    {

        $activeClass = $this->active ? 'bg-gray-100' : '';

        return <<<HTML
            <a href="{ $this->href }" class="flex items-center p-2 text-gray-900 rounded-lg hover:bg-gray-100 group {$activeClass}">
                <span class="w-6 h-6 inline-flex justify-center items-center text-gray-500">
                    <i class="{ $this->icon }"></i>
                </span>
                <span class="ms-3">{$this->name}</span>
            </a>
        HTML;
    }

    public function authorize(): bool
    {
        return true;
    }
}