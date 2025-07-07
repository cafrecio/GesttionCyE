<?php
// File: app/Http/Livewire/CreateLocalidad.php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Localidade;

class CreateLocalidad extends Component
{
    public $provinciaId;
    public $nombre;

    protected $rules = [
        'provinciaId' => 'required|exists:provincias,id',
        'nombre'      => 'required|string|max:100',
    ];

    public function mount($provincia = null)
    {
        $this->provinciaId = $provincia;
    }

    public function save()
    {
        $this->validate();
        $localidad = Localidade::create([
            'provincia_id' => $this->provinciaId,
            'nombre'       => $this->nombre,
        ]);

        // Emitir evento para que el padre recargue el select
        $this->emitUp('localidadCreated', $localidad->id, $localidad->nombre);
        $this->reset('nombre');
        $this->dispatchBrowserEvent('close-create-localidad');
    }

    public function render()
    {
        return view('livewire.create-localidad');
    }
}
