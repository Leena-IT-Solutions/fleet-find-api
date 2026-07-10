<?php

use App\Models\User;
use App\Services\Msg91Service;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    public string $name = '';
    public string $email = '';
    public string $mobile = '';
    public string $password = '';
    public string $password_confirmation = '';
    
    public bool $otpEnabled = false;
    public bool $otpSent = false;
    public string $otp = '';
    public string $errorMessage = '';

    /**
     * Mount component and load OTP configuration.
     */
    public function mount(): void
    {
        $this->otpEnabled = (bool) config('services.msg91.otp_enabled', false);
    }

    /**
     * Handle sending registration OTP.
     */
    public function sendOtp(Msg91Service $msg91Service): void
    {
        $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'mobile' => ['required', 'string', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
        ]);

        $this->errorMessage = '';
        
        if ($msg91Service->sendOtp($this->mobile)) {
            $this->otpSent = true;
        } else {
            $this->errorMessage = 'Failed to send OTP. Please check your mobile number and try again.';
        }
    }

    /**
     * Resend verification OTP.
     */
    public function resendOtp(Msg91Service $msg91Service): void
    {
        $this->errorMessage = '';
        if ($msg91Service->sendOtp($this->mobile)) {
            session()->flash('status', 'OTP has been resent successfully.');
        } else {
            $this->errorMessage = 'Failed to resend OTP. Please try again.';
        }
    }

    /**
     * Handle the registration request and verify OTP.
     */
    public function register(Msg91Service $msg91Service): void
    {
        if ($this->otpEnabled) {
            if (!$this->otpSent) {
                $this->sendOtp($msg91Service);
                return;
            }

            $this->validate([
                'otp' => ['required', 'string', 'min:4', 'max:6'],
            ]);

            $this->errorMessage = '';

            if (!$msg91Service->verifyOtp($this->mobile, $this->otp)) {
                $this->errorMessage = 'The OTP code is invalid. Please try again.';
                return;
            }
        }

        // Proceed with user creation
        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'mobile' => ['required', 'string', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
        ]);

        $validated['password'] = Hash::make($validated['password']);

        event(new Registered($user = User::create($validated)));

        Auth::login($user);

        $this->redirect(route('dashboard', absolute: false), navigate: true);
    }

    /**
     * Cancel OTP verification and go back to editing details.
     */
    public function back(): void
    {
        $this->otpSent = false;
        $this->otp = '';
        $this->errorMessage = '';
    }
}; ?>

<div>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    @if ($errorMessage)
        <div class="mb-4 text-xs font-medium text-rose-500 bg-rose-50 border border-rose-100 px-3 py-2 rounded-lg">
            {{ $errorMessage }}
        </div>
    @endif

    <form wire:submit="register">
        @if (!$otpSent)
            <!-- Name -->
            <div>
                <x-input-label for="name" :value="__('Name')" />
                <x-text-input wire:model="name" id="name" class="block mt-1 w-full" type="text" name="name" required autofocus autocomplete="name" />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            <!-- Email Address -->
            <div class="mt-4">
                <x-input-label for="email" :value="__('Email')" />
                <x-text-input wire:model="email" id="email" class="block mt-1 w-full" type="email" name="email" required autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Mobile Number -->
            <div class="mt-4">
                <x-input-label for="mobile" :value="__('Mobile Number')" />
                <x-text-input wire:model="mobile" id="mobile" class="block mt-1 w-full" type="text" name="mobile" required autocomplete="tel" placeholder="e.g. 9988776655" />
                <x-input-error :messages="$errors->get('mobile')" class="mt-2" />
            </div>

            <!-- Password -->
            <div class="mt-4">
                <x-input-label for="password" :value="__('Password')" />

                <x-text-input wire:model="password" id="password" class="block mt-1 w-full"
                                type="password"
                                name="password"
                                required autocomplete="new-password" />

                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Confirm Password -->
            <div class="mt-4">
                <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

                <x-text-input wire:model="password_confirmation" id="password_confirmation" class="block mt-1 w-full"
                                type="password"
                                name="password_confirmation" required autocomplete="new-password" />

                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>

            <div class="flex items-center justify-end mt-6">
                <a class="underline text-sm text-slate-500 hover:text-slate-700 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}" wire:navigate>
                    {{ __('Already registered?') }}
                </a>

                <x-primary-button class="ms-4">
                    {{ $otpEnabled ? __('Send OTP') : __('Register') }}
                </x-primary-button>
            </div>
        @else
            <!-- OTP Entry View -->
            <div class="text-center mb-6">
                <h3 class="text-lg font-bold text-slate-800 mb-1">Verify Mobile Number</h3>
                <p class="text-xs text-slate-500">We have sent a verification code to <span class="font-medium text-slate-800">{{ $mobile }}</span>.</p>
            </div>

            <div>
                <x-input-label for="otp" :value="__('Enter Verification OTP')" />
                <x-text-input wire:model="otp" id="otp" class="block mt-1 w-full text-center tracking-[0.75em] font-bold text-lg" type="text" name="otp" required autofocus placeholder="••••••" maxlength="6" autocomplete="one-time-code" />
                <x-input-error :messages="$errors->get('otp')" class="mt-2" />
            </div>

            <div class="flex items-center justify-between mt-6">
                <button type="button" wire:click="back" class="text-sm text-slate-500 hover:text-slate-700 underline focus:outline-none">
                    {{ __('Back / Edit Details') }}
                </button>

                <div class="flex items-center gap-3">
                    <button type="button" wire:click="resendOtp" class="text-sm text-indigo-600 hover:text-indigo-500 underline focus:outline-none">
                        {{ __('Resend OTP') }}
                    </button>
                    
                    <x-primary-button>
                        {{ __('Verify & Register') }}
                    </x-primary-button>
                </div>
            </div>
        @endif
    </form>
</div>
