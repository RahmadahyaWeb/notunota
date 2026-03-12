<?php

use App\Models\BusinessInvite;
use Illuminate\Support\Str;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithPagination;

new class extends Component
{
    use WithPagination;

    public $business;

    public $email;

    public $role = 'staff';

    public $employee_id;

    public $invite_link;

    protected $rules = [
        'email' => 'required|email',
        'role' => 'required|in:admin,staff',
    ];

    public function mount()
    {
        $this->authorize('manageUsers', tenant());

        $this->business = tenant();
    }

    public function resetForm()
    {
        $this->reset([
            'email',
            'role',
            'employee_id',
        ]);

        $this->role = 'staff';
    }

    /*
    |--------------------------------------------------------------------------
    | INVITE LINK
    |--------------------------------------------------------------------------
    */

    public function generateInvite()
    {
        $token = Str::random(40);

        $invite = BusinessInvite::create([
            'business_id' => $this->business->id,
            'token' => $token,
            'role' => $this->role,
            'expired_at' => now()->addMinutes(10),
        ]);

        $this->invite_link = url('/join/'.$invite->token);
    }

    /*
    |--------------------------------------------------------------------------
    | EDIT EMPLOYEE
    |--------------------------------------------------------------------------
    */

    public function edit($id)
    {
        $user = $this->business
            ->users()
            ->where('users.id', $id)
            ->first();

        $this->employee_id = $user->id;
        $this->email = $user->email;
        $this->role = $user->pivot->role;

        $this->modal('add-employee')->show();
    }

    public function updateRole()
    {
        $this->validate();

        $this->business
            ->users()
            ->updateExistingPivot(
                $this->employee_id,
                ['role' => $this->role]
            );

        $this->resetForm();

        $this->modal('add-employee')->close();

    }

    /*
    |--------------------------------------------------------------------------
    | DELETE EMPLOYEE
    |--------------------------------------------------------------------------
    */

    public function confirmDelete($id)
    {
        $this->employee_id = $id;

        $this->modal('delete-employee')->show();

    }

    public function delete()
    {
        $this->business
            ->users()
            ->detach($this->employee_id);

        $this->resetForm();

        $this->modal('delete-employee')->close();

    }

    /*
    |--------------------------------------------------------------------------
    | DATA
    |--------------------------------------------------------------------------
    */

    #[Computed]
    public function employees()
    {
        return $this->business
            ->users()
            ->wherePivot('role', '!=', 'owner')
            ->paginate(10);
    }

    #[Computed]
    public function invites()
    {
        return BusinessInvite::where('business_id', $this->business->id)
            ->where(function ($query) {
                $query->whereNull('expired_at')
                    ->orWhere('expired_at', '>', now());
            })
            ->latest()
            ->get();
    }
};
