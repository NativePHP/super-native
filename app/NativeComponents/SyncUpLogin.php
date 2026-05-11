<?php

namespace App\NativeComponents;

use Native\Mobile\Edge\NativeComponent;
use Native\Mobile\Edge\Transition;

class SyncUpLogin extends NativeComponent
{
    public string $email = '';

    public string $password = '';

    public bool $showPassword = false;

    public function updateEmail(string $value): void
    {
        $this->email = $value;
    }

    public function updatePassword(string $value): void
    {
        $this->password = $value;
    }

    public function toggleVisibility(): void
    {
        $this->showPassword = ! $this->showPassword;
    }

    public function login(): void
    {
        $this->replace('/syncup')->transition(Transition::Fade);
    }

    /** Skip the form entirely — convenient for demo browsing. */
    public function skipLogin(): void
    {
        $this->login();
    }

    public function forgotPassword(): void
    {
        // Demo stub — would push a password reset flow.
    }

    public function createAccount(): void
    {
        // Demo stub — would push the registration flow.
    }

    public function loginWithGoogle(): void
    {
        $this->login();
    }

    public function loginWithApple(): void
    {
        $this->login();
    }

    public function render(): \Illuminate\View\View
    {
        return view('syncup.login');
    }
}
