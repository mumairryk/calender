<?php

namespace App\Livewire;

use App\Models\Event;
use Livewire\Component;

class EventForm extends Component
{
    public $title;
    public $date;
    public $description;
    public $timeSlot;
    public $color;
    public function render()
    {
        return view('livewire.event-form');
    }

    public function saveEvent()
    {
        $this->validate([
            'title' => 'required',
            'date' => 'required|date',
            'timeSlot' => 'required',
            'color' => 'required',
        ]);
        Event::create([
            'name' => $this->title,
            'date' => $this->date,
            'description' => $this->description,
            'time_slot' => $this->timeSlot,
            'color' => $this->color,
            'user_id' => auth()->id(),
        ]);
    }

}
