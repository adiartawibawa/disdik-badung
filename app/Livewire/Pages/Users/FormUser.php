<?php

namespace App\Livewire\Pages\Users;

use App\Models\Role;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use LivewireUI\Modal\ModalComponent;

class FormUser extends ModalComponent
{
    public $updateData = false;
    public $updatePassword = false;

    public $name = '';
    public $username = '';
    public $email = '';
    public $password = '';
    public $password_confirmation = '';

    public User $user;

    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:' . User::class,
            'password' => 'required|string|confirmed', Password::defaults(),
        ];
    }

    public function mount()
    {
        if (!empty($this->user)) {
            $this->updateData = true;
            $this->name = $this->user->name;
            $this->username = $this->user->username;
            $this->email = $this->user->email;
        }
    }

    public function render()
    {
        return view('livewire.pages.users.form-user');
    }

    public function resetFields()
    {
        $this->name = '';
        $this->username = '';
        $this->email = '';
        $this->password = '';
        $this->password_confirmation = '';
    }

    public function store()
    {
        $validated = $this->validate();

        $validated['password'] = Hash::make($validated['password']);

        try {
            event(new Registered(($user = User::create($validated))));

            $user->assignRole(Role::USER);

            session()->flash('success', 'User Created Successfully!!');

            $this->resetFields();

            $this->closeModal();

            return redirect()->route('users');
        } catch (\Exception $e) {

            session()->flash('error', 'Something goes wrong while creating user!!');
            $this->resetFields();
        }
    }

    public function cancel()
    {
        $this->closeModal();
        $this->updateData = false;
        $this->updatePassword = false;
        $this->resetFields();
    }

    public function update()
    {
        // $this->validate();

        try {
            $this->user->update([
                'name' => $this->name,
                'email' => $this->email,
                'username' => $this->username,
            ]);

            if ($this->updatePassword) {
                $this->user->update([
                    'password' => Hash::make($this->password)
                ]);
            }

            session()->flash('success', 'User Updated Successfully!!');

            $this->cancel();

            return redirect()->route('users');
        } catch (\Exception $e) {

            session()->flash('error', 'Something goes wrong while updating user!!');

            $this->cancel();
        }
    }

    public function isUpdatePassword()
    {
        $this->updatePassword = true;
    }
}
