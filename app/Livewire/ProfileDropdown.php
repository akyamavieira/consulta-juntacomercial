<?php

namespace App\Livewire;

use Livewire\Component;


class ProfileDropdown extends Component
{
    public $dropdownVisible = false;

    public function toggleDropdown()
    {
        $this->dropdownVisible = !$this->dropdownVisible;
    }

    public function closeDropdown()
    {
        $this->dropdownVisible = false;
    }

    public function render()
    {
        return view('livewire.profile-dropdown');
    }
}