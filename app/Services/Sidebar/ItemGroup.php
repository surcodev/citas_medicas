<?php

namespace App\Services\Sidebar;

use ItemLink;
use WireUi\Components\Dropdown\Item;

class ItemGroup implements ItemSidebar
{
    
    protected string $title;
    protected string $icon;
    protected string $active;
    protected array $items = [];

    public function __construct(string $title, string $icon, string $active)
    {
        $this->title = $title;
        $this->icon = $icon;
        $this->active = $active;
    }

    public function add(ItemLink $item): self
    {
        $this->items[] = $item;
        return $this;
    }

    public function render(): string
    {
        return view('sidebar.item-group', [
            'title' => $this->title,
            'icon' => $this->icon,
            'active' => $this->active,
            'items' => $this->items,
        ])->render();
    }

    public function authorize(): bool
    {
        return true;
    }
}