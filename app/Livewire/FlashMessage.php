<?php

namespace App\Livewire; // Assurez-vous que le namespace est toujours correct

use Livewire\Component;
use Livewire\Attributes\On; // N'oubliez pas d'importer cet attribut

class FlashMessage extends Component
{
    public $message = '';
    public $type = 'success'; // 'success', 'error', 'warning', etc.
    public $show = false;

    // Écoute l'événement 'flash' émis par d'autres composants
    #[On('flash')]
    public function flash($type, $message)
    {
        $this->message = $message;
        $this->type = $type;
        $this->show = true;

        // Ancien: $this->dispatch('hide-flash-message')->self()->delay(3000);
        // La logique de masquage se fera uniquement dans la vue avec Alpine.js
    }

    // La méthode hide() n'est plus nécessaire ici car Alpine.js gère le masquage
    // public function hide()
    // {
    //     $this->show = false;
    // }

    public function render()
    {
        return view('livewire.flash-message');
    }
}
