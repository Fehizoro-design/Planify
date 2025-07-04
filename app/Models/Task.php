<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon; // Make sure this is imported!

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'description',
        'due_date',
        'completed',
    ];

    protected $casts = [
        'completed' => 'boolean',
        'due_date' => 'date', // This cast should handle most cases
    ];

    /**
     * Get the human-readable due date.
     *
     * @return string
     */
    public function getHumanDueDateAttribute()
    {
        // If due_date is null from the database or not a date object, return empty.
        // The 'date' cast should make it Carbon or null, but this adds robustness.
        if (!($this->due_date instanceof \DateTimeInterface)) {
            return '';
        }

        // Ensure it's a Carbon instance for its extended methods
        $dueDate = Carbon::parse($this->due_date);

        // If the date is today
        if ($dueDate->isToday()) {
            return 'Aujourd\'hui';
        }

        // If the date is tomorrow
        if ($dueDate->isTomorrow()) {
            return 'Demain';
        }

        // If the date is in the past
        if ($dueDate->isPast()) {
            return 'Dépassée (' . $dueDate->format('d/m') . ')';
        }

        // For future dates or other cases
        return $dueDate->format('d/m/Y');
    }

    /**
     * Get the CSS class for due date emphasis.
     *
     * @return string
     */
    public function getDueDateClassAttribute()
    {
        // If due_date is null or not a date object, return empty.
        if (!($this->due_date instanceof \DateTimeInterface)) {
            return '';
        }

        // Ensure it's a Carbon instance for its extended methods
        $dueDate = Carbon::parse($this->due_date);

        // If the date is in the past and not completed, mark as red
        if ($dueDate->isPast() && !$this->completed) {
            return 'text-red-500 font-semibold';
        }

        // If the date is today or tomorrow, mark as orange
        if ($dueDate->isToday() || $dueDate->isTomorrow()) {
            return 'text-orange-500';
        }

        return ''; // No special class
    }
}
