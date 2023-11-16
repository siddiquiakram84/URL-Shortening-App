<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-indigo-800 text-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h1 class="text-3xl font-bold mb-4">Welcome, {{ Auth::user()->name }}!</h1>
                    <p class="text-lg">{{ __("You're logged in to your awesome dashboard.") }}</p>
                </div>
            </div>
        </div>
    </div>
    

    <style>
        body {
            background-color: #f0f0f0; /* Set a light background color for the entire page */
        }

        .bg-indigo-800 {
            background-color: #4a5568; /* Update the background color to indigo shade */
        }

        .bg-white {
            background-color: #ffffff; /* Update the background color of inner containers to white */
        }

        /* Add some padding and border-radius for a cleaner look */
        .max-w-7xl {
            padding: 20px;
            border-radius: 8px;
        }

        /* Add a subtle box-shadow for depth */
        .sm\:rounded-lg {
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        /* Add a fade-in animation for a smooth appearance */
        @keyframes fadeIn {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }

        /* Apply the animation to the container */
        .max-w-7xl {
            animation: fadeIn 0.5s ease-in-out;
        }
    </style>
</x-app-layout>
