<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    // public function boot(): void
    // {
    //     //
    // }
    public function boot()
    {
        Validator::extend('sanitize_url', function ($attribute, $value, $parameters, $validator) {

            // Check if the URL is whitespace
            if (trim($value) === '') {
                return false;
            }

        // Check if the URL has an extension
        $hasExtension = preg_match('/\.[a-zA-Z]{2,}$/', $value);
        if (!$hasExtension) {
            return false;
        }

        // Check if the URL ends with a domain extension (e.g., .com, .org)
        $endsWithDomainExtension = preg_match('/\.[a-zA-Z]{2,}$/', parse_url($value, PHP_URL_HOST));
        if (!$endsWithDomainExtension) {
            return false;
        }

        // Check if the URL has a dot followed by at least one character to its right
        $hasDotAndCharacterToRight = preg_match('/\.[a-zA-Z]$/', $value);
        if (!$hasDotAndCharacterToRight) {
            return false;
        }
        });
    }
}
