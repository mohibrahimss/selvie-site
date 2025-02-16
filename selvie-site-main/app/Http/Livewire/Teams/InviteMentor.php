<?php

namespace App\Http\Livewire\Teams;

use App\Models\Team;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Laravel\Jetstream\Jetstream;
use Laravel\Jetstream\Mail\TeamInvitation;
use Livewire\Component;

class InviteMentor extends Component
{
    public $team;
    public $email = '';
    public $role = 'mentor';

    protected $rules = [
        'email' => 'required|email',
        'role' => 'required|in:mentor,staff'
    ];

    public function mount(Team $team)
    {
        $this->team = $team;
    }

    public function inviteMentor()
    {
        $this->validate();

        if (!Auth::user()->hasTeamPermission($this->team, 'manage-mentors')) {
            abort(403);
        }

        $invitation = $this->team->teamInvitations()->create([
            'email' => $this->email,
            'role' => $this->role,
        ]);

        Mail::to($this->email)->send(new TeamInvitation($invitation));

        $this->emit('invited');
        $this->email = '';

        $this->dispatchBrowserEvent('banner-message', [
            'style' => 'success',
            'message' => 'Invitation sent successfully!'
        ]);
    }

    public function render()
    {
        return view('teams.invite-mentor', [
            'roles' => [
                'mentor' => 'Mentor',
                'staff' => 'School Staff'
            ],
            'availableRoles' => array_values(Jetstream::$roles),
        ]);
    }
} 