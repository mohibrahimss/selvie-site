<?php

namespace App\Http\Livewire\Teams;

use App\Models\School;
use Illuminate\Support\Facades\Auth;
use Laravel\Jetstream\InteractsWithBanner;
use Livewire\Component;

class SchoolSettings extends Component
{
    use InteractsWithBanner;

    public $team;
    public $school;
    public $state = [];

    protected $rules = [
        'state.name' => 'required|string|max:255',
        'state.address' => 'nullable|string|max:255',
        'state.contact_email' => 'required|email',
        'state.phone' => 'nullable|string|max:20',
    ];

    public function mount($team)
    {
        $this->team = $team;
        $this->school = School::where('team_id', $team->id)->firstOrFail();
        $this->state = $this->school->withoutRelations()->toArray();
    }

    public function updateSchoolSettings()
    {
        $this->validate();

        if (!Auth::user()->hasTeamPermission($this->team, 'manage-school')) {
            abort(403);
        }

        $this->school->update($this->state);

        $this->banner('School settings have been updated.');
    }

    public function render()
    {
        return view('teams.school-settings');
    }
} 