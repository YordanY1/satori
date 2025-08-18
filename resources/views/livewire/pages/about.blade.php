<section class="relative bg-gradient-to-b from-gray-50 via-white to-gray-50">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12 space-y-12">

        <div>
            <h1 class="text-3xl font-bold mb-4">{{ __('about.mission_title') }}</h1>
            <p class="text-gray-700 leading-relaxed">
                {{ __('about.mission_body') }}
            </p>
        </div>

        <div>
            <h2 class="text-2xl font-semibold mb-3">{{ __('about.history_title') }}</h2>
            <p class="text-gray-700 leading-relaxed">
                {{ __('about.history_body') }}
            </p>
        </div>

        <div>
            <h2 class="text-2xl font-semibold mb-6">{{ __('about.team_title') }}</h2>
            <div class="grid gap-6 sm:grid-cols-2">
                <div class="text-center">
                    <img src="{{ asset('images/team.jpg') }}" alt="{{ __('about.team_member_alt') }}"
                        class="w-32 h-32 rounded-full mx-auto mb-3 shadow-lg ring-2 ring-accent/30">
                    <h3 class="font-bold">Иван Петров</h3>
                    <p class="text-sm text-gray-600">{{ __('about.role.founder') }}</p>
                </div>
                <div class="text-center">
                    <img src="{{ asset('images/team.jpg') }}" alt="{{ __('about.team_member_alt') }}"
                        class="w-32 h-32 rounded-full mx-auto mb-3 shadow-lg ring-2 ring-accent/30">
                    <h3 class="font-bold">Мария Георгиева</h3>
                    <p class="text-sm text-gray-600">{{ __('about.role.editor_in_chief') }}</p>
                </div>
            </div>
        </div>

        <div>
            <h2 class="text-2xl font-semibold mb-3">{{ __('about.principles_title') }}</h2>
            <ul class="space-y-2 list-disc list-inside text-gray-700">
                <li><strong>{{ __('about.principle.quality') }}</strong></li>
                <li><strong>{{ __('about.principle.mindfulness') }}</strong></li>
                <li><strong>{{ __('about.principle.translations') }}</strong></li>
            </ul>
        </div>

    </div>
</section>
