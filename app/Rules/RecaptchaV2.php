<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\Http;

class RecaptchaV2 implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (blank($value)) {
            $fail(__('validation.custom.recaptcha.required', ['attribute' => $attribute]));
            return;
        }

        $secret = config('services.recaptcha.secret');

        try {
            $response = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
                'secret'   => $secret,
                'response' => $value,
                'remoteip' => request()->ip(),
            ]);

            if (!$response->ok() || !data_get($response->json(), 'success')) {
                $fail(__('validation.custom.recaptcha.invalid'));
            }
        } catch (\Throwable $e) {
            $fail(__('validation.custom.recaptcha.failed'));
        }
    }
}
