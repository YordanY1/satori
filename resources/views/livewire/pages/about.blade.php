<section class="relative bg-gradient-to-b from-gray-50 via-white to-gray-50 py-20">
    <div class="max-w-5xl mx-auto px-6 sm:px-8 lg:px-10 space-y-24">

        {{-- Mission --}}
        <div class="text-center space-y-6">
            <h1 class="text-4xl sm:text-5xl font-extrabold text-gray-900 tracking-tight">
                {{ __('about.mission_title') }}
            </h1>
            <p class="text-lg sm:text-xl text-gray-700 leading-relaxed max-w-3xl mx-auto">
                {{ __('about.mission_body') }}
            </p>
        </div>

        {{-- History --}}
        <div class="space-y-4">
            <h2 class="text-3xl font-bold text-gray-900">
                {{ __('about.history_title') }}
            </h2>
            <p class="text-gray-700 leading-relaxed text-lg">
                {{ __('about.history_body') }}
            </p>
        </div>

        {{-- Team --}}
        <div class="space-y-10">
            <h2 class="text-3xl font-bold text-gray-900 text-center">
                {{ __('about.team_title') }}
            </h2>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-10">
                @foreach (__('about.team_members') as $member)
                    <div
                        class="text-center p-6 bg-white rounded-2xl shadow-sm hover:shadow-md transition-shadow duration-300 space-y-2">
                        <h3 class="text-xl font-semibold text-gray-900">{{ $member['name'] }}</h3>
                        <p class="text-sm font-medium text-accent uppercase tracking-wide">{{ $member['role'] }}</p>
                        <p class="text-gray-700 text-sm leading-relaxed">{{ $member['bio'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Principles --}}
        <div class="space-y-6">
            <h2 class="text-3xl font-bold text-gray-900">
                {{ __('about.principles_title') }}
            </h2>
            <ul class="space-y-3 list-disc list-inside text-gray-700 leading-relaxed text-lg">
                @foreach (__('about.principles') as $principle)
                    <li>{{ $principle }}</li>
                @endforeach
            </ul>
        </div>

    </div>
</section>
