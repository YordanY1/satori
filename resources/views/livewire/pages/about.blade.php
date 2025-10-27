<section class="relative overflow-hidden bg-gradient-to-b from-amber-50 via-white to-amber-50 py-24">
    <div class="max-w-6xl mx-auto px-6 lg:px-12 space-y-28">

        {{-- Mission --}}
        <div class="text-center space-y-8">
            <h1 class="text-5xl sm:text-6xl font-extrabold tracking-tight text-gray-900">
                {{ __('about.mission_title') }}
            </h1>
            <p class="max-w-3xl mx-auto text-lg sm:text-xl text-gray-700 leading-relaxed">
                {{ __('about.mission_body') }}
            </p>

            <div class="flex justify-center mt-8">
                <div class="h-1 w-32 bg-accent rounded-full"></div>
            </div>
        </div>

        {{-- History --}}
        <div class="relative">
            <div
                class="absolute inset-0 bg-gradient-to-r from-accent/10 via-transparent to-accent/10 rounded-3xl blur-3xl">
            </div>
            <div class="relative bg-white shadow-sm rounded-2xl p-10 md:p-14 space-y-6">
                <h2 class="text-3xl font-bold text-gray-900">
                    {{ __('about.history_title') }}
                </h2>
                <p class="text-lg text-gray-700 leading-relaxed">
                    {{ __('about.history_body') }}
                </p>
            </div>
        </div>

        {{-- Team --}}
        <div class="space-y-12">
            <h2 class="text-4xl font-bold text-center text-gray-900">
                {{ __('about.team_title') }}
            </h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-10">
                @foreach (__('about.team_members') as $member)
                    <div
                        class="group relative bg-white rounded-2xl shadow-md hover:shadow-xl transition-all duration-500 overflow-hidden">
                        <div
                            class="absolute inset-0 bg-gradient-to-br from-accent/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity">
                        </div>
                        <div class="p-8 text-center space-y-3 relative">
                            <div
                                class="mx-auto h-20 w-20 rounded-full bg-accent/20 flex items-center justify-center text-accent font-bold text-2xl">
                                {{ strtoupper(substr($member['name'], 0, 1)) }}
                            </div>
                            <h3 class="text-xl font-semibold text-gray-900">{{ $member['name'] }}</h3>
                            <p class="text-sm uppercase font-medium text-accent tracking-wide">{{ $member['role'] }}</p>
                            <p class="text-gray-700 leading-relaxed text-sm">{{ $member['bio'] }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Principles --}}
        <div class="relative space-y-10">
            <div class="absolute -top-10 left-0 w-64 h-64 bg-accent/10 blur-3xl rounded-full"></div>
            <div class="absolute bottom-0 right-0 w-80 h-80 bg-accent/10 blur-3xl rounded-full"></div>

            <h2 class="text-4xl font-bold text-gray-900">
                {{ __('about.principles_title') }}
            </h2>
            <ul class="space-y-4 text-lg text-gray-700 leading-relaxed list-disc list-inside">
                @foreach (__('about.principles') as $principle)
                    <li class="hover:text-accent transition-colors duration-200">{{ $principle }}</li>
                @endforeach
            </ul>
        </div>

    </div>
</section>
