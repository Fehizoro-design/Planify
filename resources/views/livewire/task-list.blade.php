<div>
    <h2 class="text-2xl sm:text-3xl font-bold mb-6 text-gray-800">Mes tâches de la journée</h2>

    @if ($tasks->isEmpty())
        <p class="text-gray-600 text-center py-8 text-lg">Aucune tâche pour le moment. Ajoutez-en une !</p>
    @else
        <div class="max-h-[400px] overflow-y-auto pr-2">
            <ul class="space-y-4">
                @foreach ($tasks as $task)
                    <li class="p-4 sm:p-5 bg-white rounded-lg shadow hover:shadow-md transition-all duration-300 ease-in-out border border-gray-100">
                        @if ($editingTaskId === $task->id)
                            {{-- Formulaire d'édition (pas de changement ici) --}}
                            <form wire:submit.prevent="updateTask" class="flex flex-col md:flex-row items-start md:items-center space-y-3 md:space-y-0 md:space-x-3">
                                <div class="flex-grow w-full">
                                    <input
                                        type="text"
                                        wire:model="editingDescription"
                                        class="block w-full px-4 py-2 text-lg text-gray-800 bg-gray-50 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition duration-200 ease-in-out @error('editingDescription') ring-red-500 @enderror"
                                        placeholder="Modifier la description"
                                    >
                                    @error('editingDescription') <p class="text-red-500 text-sm italic mt-2">{{ $message }}</p> @enderror
                                </div>
                                <div class="w-full md:w-auto">
                                    <input
                                        type="date"
                                        wire:model="editingDueDate"
                                        class="block w-full px-4 py-2 text-lg text-gray-800 bg-gray-50 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition duration-200 ease-in-out @error('due_date') ring-red-500 @enderror"
                                    >
                                    @error('due_date') <p class="text-red-500 text-sm italic mt-2">{{ $message }}</p> @enderror
                                </div>
                                <div class="flex space-x-2 mt-2 md:mt-0 w-full md:w-auto justify-end">
                                    <button type="submit" class="flex-shrink-0 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg text-base focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition duration-200 ease-in-out">
                                        Sauvegarder
                                    </button>
                                    <button wire:click="cancelEdit" type="button" class="flex-shrink-0 px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white font-medium rounded-lg text-base focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition duration-200 ease-in-out">
                                        Annuler
                                    </button>
                                </div>
                            </form>
                        @else
                            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 sm:gap-4">
                                <div class="flex-auto min-w-0">
                                    <span class="text-lg sm:text-xl font-medium block {{ $task->completed ? 'line-through text-gray-500' : 'text-gray-800' }}">
                                        {{ $task->description }}
                                        @if ($task->due_date)
                                            <span class="text-sm ml-2 {{ $task->due_date_class }} whitespace-nowrap inline-block mt-1 sm:mt-0">
                                                ({{ $task->human_due_date }})
                                            </span>
                                        @endif
                                    </span>
                                </div>

                                <div class="flex flex-wrap gap-2 justify-start sm:justify-end flex-shrink-0">
                                    {{-- Bouton Terminer/À faire --}}
                                    <button
                                        wire:click="toggleCompleted({{ $task->id }})"
                                        class="p-2 rounded-md text-white focus:outline-none focus:ring-2 focus:ring-offset-2
                                            {{ $task->completed ? 'bg-yellow-500 hover:bg-yellow-600 focus:ring-yellow-500' : 'bg-green-500 hover:bg-green-600 focus:ring-green-500' }}"
                                        title="{{ $task->completed ? 'Marquer comme à faire' : 'Marquer comme terminé' }}" {{-- Ajout de l'attribut title --}}
                                    >
                                        <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        <span class="sr-only">{{ $task->completed ? 'Marquer comme à faire' : 'Marquer comme terminé' }}</span>
                                    </button>

                                    {{-- Bouton Éditer --}}
                                    <button
                                        wire:click="editTask({{ $task->id }})"
                                        class="p-2 bg-purple-500 hover:bg-purple-600 text-white rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2 transition-colors duration-200"
                                        title="Éditer la tâche" {{-- Ajout de l'attribut title --}}
                                    >
                                        <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.687a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v5h-5l-1.28-1.28" />
                                        </svg>
                                        <span class="sr-only">Éditer</span>
                                    </button>

                                    {{-- Bouton Supprimer --}}
                                    <button
                                        wire:click="deleteTask({{ $task->id }})"
                                        wire:confirm="Êtes-vous sûr de vouloir supprimer cette tâche ?"
                                        class="p-2 bg-red-500 hover:bg-red-600 text-white rounded-md focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition-colors duration-200"
                                        title="Supprimer la tâche" {{-- Ajout de l'attribut title --}}
                                    >
                                        <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.162m-1.022-.161L18.64 19.67m-5.864-15.86l-5.86 15.86m1.664-5.864l1.66 5.864m-6.08-15.86l1.936 5.864m-1.332-5.864l-1.336 5.864M4.5 6h15m-16.5 0a2.25 2.25 0 002.25 2.25V21a2.25 2.25 0 002.25 2.25h13.5a2.25 2.25 0 002.25-2.25V8.25a2.25 2.25 0 002.25-2.25H4.5z" />
                                        </svg>
                                        <span class="sr-only">Supprimer</span>
                                    </button>
                                </div>
                            </div>
                        @endif
                    </li>
                @endforeach
            </ul>
        </div>
    @endif
</div>