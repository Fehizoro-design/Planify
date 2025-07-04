<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Task;

class TaskForm extends Component
{
    public $description;
    public $due_date; // This will hold the date from the form

    protected $rules = [
        'description' => 'required|string|max:255',
        'due_date' => 'nullable|date', // 'nullable' allows it to be null
    ];

    public function createTask()
    {
        $this->validate();

        // Convert empty string to null for due_date before saving
        // This is the crucial part to fix the SQL error
        $validatedData = [
            'description' => $this->description,
            'due_date' => $this->due_date ? $this->due_date : null, // If due_date is empty, set to null
            'completed' => false, // Ensure default completed status
        ];

        Task::create($validatedData);

        $this->reset(['description', 'due_date']); // Clear the form fields
        $this->dispatch('taskAdded'); // Dispatch event for TaskList to refresh
        $this->dispatch('flash', type: 'success', message: 'Tâche ajoutée avec succès !');
    }

    public function render()
    {
        return view('livewire.task-form');
    }
}
