<?php

namespace App\Livewire\Admin;

use App\Models\Doctor;
use App\Models\Schedule;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Livewire\Attributes\Computed;
use Livewire\Component;

class ScheduleManager extends Component
{

    public Doctor $doctor;
    public $schedule = [];

    public $days = [];

    public $appointment_duration;
    public $start_time;
    public $end_time;

    public $intervals;

    #[Computed()]
    public function hourBlocks(){
        return CarbonPeriod::create(
            Carbon::createFromTimeString($this->start_time),
            '1 hour',
            Carbon::createFromTimeString($this->end_time),
        )->excludeEndDate();
    }

    public function mount(){

        $this->days = config('schedule.days');
        $this->appointment_duration = config('schedule.appointment_duration');

        $this->intervals = 60 / $this->appointment_duration;
        $this->initializeSchedule();
    }

    public function initializeSchedule(){
        $schedules = $this->doctor->schedules;
        
        foreach($this->hourBlocks as $hourBlock){
            $period = CarbonPeriod::create(
                $hourBlock->copy(),
                $this->appointment_duration . ' minutes',
                $hourBlock->copy()->addHour()
            )->excludeEndDate();;

            foreach($period as $time){
                foreach($this->days as $index => $day){
                    $this->schedule[$index][$time->format('H:i:s')] = $schedules->contains(function($schedule) use ($index, $time){
                        return $schedule->day_of_week == $index && $schedule->start_time->format('H:i:s') == $time->format('H:i:s');
                    });
                }
            }
        }
    }

    public function save(){
        $this->doctor->schedules()->delete();

        foreach($this->schedule as $day_of_week => $intervals){
            foreach($intervals as $start_time => $isChecked){
                if ($isChecked){
                    Schedule::create([
                        'doctor_id' => $this->doctor->id,
                        'day_of_week' => $day_of_week,
                        'start_time' => $start_time,
                    ]);
                }
            }
        }

        $this->dispatch('swal', [
            'icon' => 'success',
            'title' => 'Horario actualizado',
            'text' => 'El horario del doctor ha sido actualizado exitosamente.',
        ]);
    }

    public function render()
    {
        return view('livewire.admin.schedule-manager');
    }
}
