<section class="relative bg-gradient-to-b from-gray-50 via-white to-gray-50">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12 space-y-16">

        {{-- Intro / Mission --}}
        <div>
            <h1 class="text-3xl font-bold mb-4 text-gray-900">
                {{ __('about.mission_title') }}
            </h1>
            <p class="text-gray-700 leading-relaxed text-lg">
                {{ __('about.mission_body') }}
            </p>
        </div>

        {{-- History --}}
        <div>
            <h2 class="text-2xl font-semibold mb-3 text-gray-900">
                {{ __('about.history_title') }}
            </h2>
            <p class="text-gray-700 leading-relaxed">
                {{ __('about.history_body') }}
            </p>
        </div>

        {{-- Team --}}
        <div>
            <h2 class="text-2xl font-semibold mb-6 text-gray-900">
                {{ __('about.team_title') }}
            </h2>

            <div class="space-y-6">
                <div class="text-center">
                    <h3 class="font-bold text-lg text-gray-900">Валери Беленски</h3>
                    <p class="text-sm text-gray-600">{{ __('about.role.founder') }}</p>
                </div>
                <div class="text-center">
                    <h3 class="font-bold text-lg text-gray-900">Тодор Беленски</h3>
                    <p class="text-sm text-gray-600">{{ __('about.role.editor_in_chief') }}</p>
                </div>
            </div>
        </div>

        {{-- Principles --}}
        <div>
            <h2 class="text-2xl font-semibold mb-4 text-gray-900">
                {{ __('about.principles_title') }}
            </h2>
            <ul class="space-y-2 list-disc list-inside text-gray-700">
                <li>{{ __('about.principle.quality') }}</li>
                <li>{{ __('about.principle.mindfulness') }}</li>
                <li>{{ __('about.principle.translations') }}</li>
            </ul>
        </div>

    </div>
</section>
