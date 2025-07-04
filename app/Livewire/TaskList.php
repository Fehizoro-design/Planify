<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Task;
use Livewire\Attributes\On;

class TaskList extends Component
{
    public $tasks;
    public $editingTaskId = null;
    public $editingDescription = '';
    public $editingDueDate = '';

    protected $rules = [
        'editingDescription' => 'required|string|max:255',
        'editingDueDate' => 'nullable|date',
    ];

    // NEW: This method runs automatically when the component is first loaded.
    public function mount()
    {
        $this->loadTasks();
    }

    // This method is called when 'taskAdded' event is dispatched or by mount()
    #[On('taskAdded')]
    public function loadTasks()
    {
        $this->tasks = Task::latest()->get(); // This populates $this->tasks
        $this->cancelEdit();
    }

    // ... (rest of your methods like toggleCompleted, deleteTask, editTask, cancelEdit, updateTask) ...

    public function toggleCompleted($taskId)
    {
        $task = Task::find($taskId);
        if ($task) {
            $task->completed = !$task->completed;
            $task->save();
            $this->loadTasks();
            $this->dispatch('flash', type: 'success', message: 'Statut de la tâche mis à jour !');
        }
    }

    public function deleteTask($taskId)
    {
        Task::destroy($taskId);
        $this->loadTasks();
        $this->dispatch('flash', type: 'success', message: 'Tâche supprimée !');
    }

    public function editTask($taskId)
    {
        $task = Task::find($taskId);
        if ($task) {
            $this->editingTaskId = $taskId;
            $this->editingDescription = $task->description;
            $this->editingDueDate = $task->due_date instanceof \DateTimeInterface
                ? $task->due_date->format('Y-m-d')
                : '';
        }
    }

    public function cancelEdit()
    {
        $this->editingTaskId = null;
        $this->editingDescription = '';
        $this->editingDueDate = '';
        $this->resetValidation();
    }

    public function updateTask()
    {
        $this->validate();

        $task = Task::find($this->editingTaskId);
        if ($task) {
            $task->description = $this->editingDescription;
            $task->due_date = $this->editingDueDate;
            $task->save();
            $this->loadTasks();
            $this->dispatch('flash', type: 'success', message: 'Tâche modifiée !');
        }
        $this->cancelEdit();
    }

    public function render()
    {
        return view('livewire.task-list');
    }
}
