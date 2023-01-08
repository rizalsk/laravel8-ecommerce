<?php

namespace App\Http\Livewire\Admin\Auth;

use Livewire\Component;
use Auth;

class Login extends Component
{
    public $email;
    public $password;

    public function render()
    {
        return view('livewire.admin.auth.login')
        ->layout('layouts.admin.main')
        ->layoutData(['bodyClass' => 'login-page']);
    }

    public function login()
    {
        $this->validate([
            'email'     => 'required|email',
            'password'  => 'required'
        ]);

        if(Auth::attempt(['email' => $this->email, 'password'=> $this->password])) {

            return redirect()->route('admin.dashboard');

        } else {
            session()->flash('status', 'Alamat Email atau Password Anda salah!.');
            return redirect()->route('admin.login');
        }
    }

}
