<div>
    <h2 class="text-2xl sm:text-3xl font-bold mb-6 text-gray-800">Ajouter une nouvelle tâche</h2>
    <form wire:submit.prevent="createTask" class="space-y-6"> {{-- Utilisation de space-y pour un espacement vertical
        constant --}}
        <div>
            <label for="description" class="block text-gray-700 text-base font-medium mb-2">Description de la
                tâche:</label>
            <input type="text" id="description" wire:model="description"
                class="block w-full px-4 py-2 text-lg text-gray-800 bg-gray-50 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200 ease-in-out @error('description') ring-red-500 @enderror"
                placeholder="Ex: Faire les courses">
            @error('description') <p class="text-red-500 text-sm italic mt-2">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="due_date" class="block text-gray-700 text-base font-medium mb-2">Date d'échéance
                (optionnel):</label>
            <input type="date" id="due_date" wire:model="due_date"
                class="block w-full px-4 py-2 text-lg text-gray-800 bg-gray-50 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200 ease-in-out @error('due_date') ring-red-500 @enderror">
            @error('due_date') <p class="text-red-500 text-sm italic mt-2">{{ $message }}</p> @enderror
        </div>

        <button type="submit"
            class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-6 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition duration-200 ease-in-out">
            Ajouter la tâche
        </button>
    </form>
</div>