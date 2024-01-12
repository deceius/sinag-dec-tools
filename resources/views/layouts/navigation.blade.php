<nav x-data="{ open: false }" class="bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('home') }}">
                        <x-application-logo class="block h-9 w-auto fill-current text-gray-800 dark:text-gray-200" />
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    <x-ui.nav.link :href="route('home')" :active="request()->routeIs('home')">
                        {{ __('Home') }}
                    </x-ui.nav.link>
                    @if(Auth::user()->is_officer)
                    <x-ui.nav.dropdown :active="request()->routeIs('officer.*')">
                        <x-slot:title>{{ __('Officer Stuff') }}</x-slot>
                        <x-slot:content>

                            @if(Auth::user()->is_regear_officer)
                            <x-ui.dropdown.item :href="route('officer.regear.index')" :active="request()->routeIs('officer.regear.*')">
                                {{ __('Regear Management') }}
                            </x-ui.dropdown.item>
                            @endif

                            @if(Auth::user()->is_build_officer)
                            <x-ui.dropdown.item :href="route('officer.build.index')" :active="request()->routeIs('officer.build.*')">
                                {{ __('ZvZ Builds Setup') }}
                            </x-ui.dropdown.item>
                            @endif
                            </form>
                        </x-slot>
                    </x-ui.nav.dropdown>
                    <x-ui.nav.dropdown :active="request()->routeIs('reports.*')">
                        <x-slot:title>{{ __('Reports') }}</x-slot>
                        <x-slot:content>
                            <x-ui.dropdown.item :href="route('reports.regear.index')" :active="request()->routeIs('reports.regear.index')">
                                {{ __('Regear Summary') }}
                            </x-ui.dropdown.item>
                        </x-slot>
                    </x-ui.nav.dropdown>
                    @endif
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ml-6">
                <x-ui.dropdown.link align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition ease-in-out duration-150">
                            <img class="h-8 w-8 rounded-full object-cover mr-2" src="{{ Auth::user()->getAvatar(['extension' => 'webp', 'size' => 32]) }}" alt="{{ Auth::user()->getTagAttribute() }}" />

                            <div style="display: flex; flex-direction: column; align-items: flex-start;">
                                {{ Auth::user()->getTagAttribute() }}
                                @if (Auth::user()->global_name)
                                    <small>Albion IGN: <u>{{ Auth::user()->ao_character_name ? Auth::user()->ao_character_name : '???' }}</u></small>
                                @endif
                            </div>

                            <div class="ml-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>
                    <x-slot:content>
                        <x-ui.dropdown.item :href="route('profile.edit')">
                            {{ __('Profile') }}
                        </x-ui.dropdown.item>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-ui.dropdown.item :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-ui.dropdown.item>
                        </form>

                    </x-slot>
                </x-ui.dropdown.link>
            </div>

            <!-- Hamburger -->
            <div class="-mr-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 dark:text-gray-500 hover:text-gray-500 dark:hover:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-900 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-900 focus:text-gray-500 dark:focus:text-gray-400 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-ui.nav.responsive :href="route('home')" :active="request()->routeIs('home')">
                {{ __('home') }}
            </x-ui.nav.responsive>
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200 dark:border-gray-600">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800 dark:text-gray-200">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-ui.nav.responsive :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-ui.nav.responsive>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-ui.nav.responsive :href="route('logout')"
                                           onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-ui.nav.responsive>
                </form>
            </div>
        </div>
    </div>
</nav>
