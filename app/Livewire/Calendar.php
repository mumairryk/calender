<?php

namespace App\Livewire;


use App\Models\Event;
use Carbon\Carbon;
use Livewire\Component;

class Calendar extends Component
{
    public $date;
    public $month;
    public $monthName;
    public $year;
    public $days = [];
    public $eventTitle;
    public $eventDate;
    public $eventDescription;
    public $eventTimeSlot;
    public $eventColor;
    public function mount()
    {
        $this->date = Carbon::now();
        $this->month = $this->date->month;
        $this->year = $this->date->year;
        $this->monthName = $this->date->monthName;
        $this->generateCalendar();
    }

    public function render()
    {
        return view('livewire.calendar');
    }

    public function selectDay($selectedDate)
    {
        //Emit event to open the modal
        $this->eventDate = $selectedDate;
        $this->eventColor='';
        $this->eventDescription='';
        $this->eventTimeSlot='';
        $this->eventTitle='';
        $this->dispatch('openEventModal', ['date' => $selectedDate]);
    }

    private function generateCalendar()
    {
        $user = auth()->user();
        // Get the first day of the month
        $firstDay = Carbon::create($this->year, $this->month, 1);

        // Determine the day of the week for the first day (0 = Sunday, 1 = Monday, etc.)
        $startDayOfWeek = $firstDay->dayOfWeek;

        // Create the days array
        $this->days = [];

        // Fill in the days before the first day of the month
        for ($i = 0; $i < $startDayOfWeek; $i++) {
            $this->days[] = [
                'date' => null,
                'number' => null,
                'selected' => false,
                'events' => [],
            ];
        }

        // Fill in the days of the month
        for ($day = 1; $day <= $firstDay->daysInMonth; $day++) {
            $date = Carbon::create($this->year, $this->month, $day);
            $this->days[] = [
                'date' => $date->format('Y-m-d'),
                'number' => $day,
                'selected' => false,
                'events' => Event::where('date', $date->format('Y-m-d'))->where('user_id',$user->id)->get(),
            ];
        }
    }
    public function saveEvent()
    {
        $this->validate([
            'eventTitle' => 'required',
            'eventDate' => 'required|date',
            'eventTimeSlot' => 'required',
            'eventColor' => 'required',
        ]);
        $model = new Event();
        $model->name = $this->eventTitle;
        $model->date = $this->eventDate;
        $model->description = $this->eventDescription;
        $model->time_slot = $this->eventTimeSlot;
        $model->color = $this->eventColor;
        $model->user_id = auth()->id();
        $model->save();
        $this->dispatch('closeEventModal');
        $this->generateCalendar();
    }
    public function preMonth($month)
    {
        if ($month == 1) {
            $this->year--;
            $this->month = 12;
        } else {
            $this->month--;
        }
        $this->monthName = Carbon::create($this->year, $this->month)->monthName;
        $this->generateCalendar();
    }
    public function nextMonth($month)
    {
        if ($month == 12) {
            $this->year++;
            $this->month = 1;
        } else {
            $this->month++;
        }
        $this->monthName = Carbon::create($this->year, $this->month)->monthName;
        $this->generateCalendar();
    }
    public function updateEventDate($newDate, $eventId)
    {
        $model = Event::find($eventId);
        $model->date = $newDate;
        $model->save();
        $this->generateCalendar();
    }
}
