<div>
    <!-- Calendar Container -->
    <div class="calendar-container">
        <h2>{{$monthName.' '. $year}} <span class="pointer" style="float: right" wire:click="nextMonth({{$month}})"> > </span> <span class="pointer" style="float: right"  wire:click="preMonth({{$month}})" > <</span></h2>
        <!-- Days of the Week -->
        <div class="weekdays ">
            @foreach(['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'] as $day)
                <div >{{ $day }}</div>
            @endforeach
        </div>
        <!-- Calendar Grid -->
        <div class="calendar-grid">
            @foreach($days as $day)
                <div data-date="{{$day['date'] }}" wire:click="selectDay('{{ $day['date'] }}')" class="{{ $day['selected'] ? 'selected' : '' }}" data-date="{{$day['date']}}">
                    <div class="day-number pointer" data-date="{{$day['date'] }}" style="width: 125px;">{{ $day['number'] }}</div>
                    @if($day['events'])
                        @foreach($day['events'] as $event)
                            <div data-event-id="{{$event->id}}" style="cursor: move;" data-date="{{$day['date'] }}" class="event {{$event->color}}">{{ $event->name .' ('. $event->time_slot .')' }}</div>
                        @endforeach
                    @endif
                </div>
            @endforeach
        </div>
    </div>
    <!-- Bootstrap Modal -->
    <div wire:ignore.self class="modal fade" id="eventModal" tabindex="-1" role="dialog" aria-labelledby="eventModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="eventModalLabel">Add Event</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form wire:submit.prevent="saveEvent">
                        <div class="form-group">
                            <label for="eventModalDate">Date</label>
                            <input type="date" wire:model="eventDate" class="form-control" id="eventModalDate" readonly />
                            @error('eventDate') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="form-group">
                            <label for="title">Event Title</label>
                            <input type="text" wire:model="eventTitle" required class="form-control" id="title" placeholder="Enter event title">
                            @error('eventTitle') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="form-group">
                            <label for="description">Event Description</label>
                            <textarea wire:model="eventDescription" class="form-control" id="description" placeholder="Enter event description"></textarea>
                            @error('eventDescription') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="form-group">
                            <label for="time_slot">Start Slot</label>
                            <select wire:model="eventTimeSlot" name="timeSlot" required class="form-control" id="time_slot">
                                <option value="">Select Time Slot</option>
                                <option value="09:00 AM">09:00 AM</option>
                                <option value="10:00 AM">10:00 AM</option>
                                <option value="11:00 AM">11:00 AM</option>
                                <option value="12:00 PM">12:00 PM</option>
                                <option value="01:00 PM">01:00 PM</option>
                                <option value="02:00 PM">02:00 PM</option>
                                <option value="03:00 PM">03:00 PM</option>
                                <option value="04:00 PM">04:00 PM</option>
                                <option value="05:00 PM">05:00 PM</option>
                                <option value="06:00 PM">06:00 PM</option>
                            </select>
                            @error('eventTimeSlot') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="form-group">
                            <label for="color">Event Color</label>
                            <select wire:model="eventColor" class="form-control" required id="color">
                                <option value="">Select Event Color</option>
                                <option value="bg-primary">Blue</option>
                                <option value="bg-secondary">Gray</option>
                                <option value="bg-success">Green</option>
                                <option value="bg-danger">Red</option>
                                <option value="bg-warning">Yellow</option>
                                <option value="bg-info">Sky Blue</option>
                                <option value="bg-light">Light</option>
                                <option value="bg-dark">Dark</option>
                            </select>
                            @error('eventColor') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="form-group mt-5">
                            <button type="submit" class="btn btn-primary">Save Event</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        window.addEventListener('openEventModal', event => {
            $('#eventModal').modal('show');
        })
        window.addEventListener('closeEventModal', event => {
            $('#eventModal').modal('hide');
        })
        function initDraggable() {
            $('.event').draggable({
                zIndex: 1000,
                revert: true,
                revertDuration: 0,
                helper: 'clone',
                start: function (event, ui) {
                    $(this).hide(); // Hide the original event during drag
                },
                stop: function (event, ui) {
                    $(this).show(); // Show the original event when dragging stops
                }
            });

            $('.calendar-grid .day-number').droppable({
                drop: function (event, ui) {
                    const droppedEvent = ui.helper.clone();
                    droppedEvent.removeClass('ui-draggable-dragging');
                    const droppedDate = $(this).data('date');

                    // Handle the server-side logic using Livewire
                @this.call('updateEventDate', droppedDate, droppedEvent.data('event-id'));
                    //refresh the page
                    location.reload();
                }
            });
        }
        initDraggable();
    </script>
</div>


