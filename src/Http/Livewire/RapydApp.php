<?php

namespace Zofe\Rapyd\Http\Livewire;

use Livewire\Attributes\On;

class RapydApp extends BaseComponent
{
    #[On('sidebar-toggle')]
    public function sidebarToggle()
    {
        session()->put('sidebar-show', ! session()->get('sidebar-show'));
    }

    public function render()
    {
        return '<div></div>';
    }
}
