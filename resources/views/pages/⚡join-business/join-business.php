<?php

use App\Models\BusinessInvite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

new class extends Component
{
    public $invite;

    public $name;

    public $email;

    public $password;

    public function mount($token)
    {
        $this->invite = BusinessInvite::where('token', $token)->firstOrFail();

        if ($this->invite->expired_at && now()->greaterThan($this->invite->expired_at)) {
            abort(403, 'Invitation expired');
        }
    }

    public function register()
    {
        $this->validate([
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        $user = User::where('email', $this->email)->first();

        if (! $user) {

            $user = User::create([
                'name' => $this->name,
                'email' => $this->email,
                'password' => bcrypt($this->password),
            ]);
        }

        $this->invite->business
            ->users()
            ->syncWithoutDetaching([
                $user->id => [
                    'role' => $this->invite->role,
                ],
            ]);

        Auth::login($user);

        $this->invite->delete();

        return redirect('/dashboard');
    }
};
