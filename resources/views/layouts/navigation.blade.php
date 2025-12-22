<nav x-data="{ open: false }" class="bg-white border-b border-slate-100">
    <!-- Primary Navigation Menu -->
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ auth()->check() ? route('dashboard') : url('/') }}">
                        <x-application-logo class="block h-9 w-auto fill-current text-emerald-700" />
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    @auth
                        <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                            {{ __('Dashboard') }}
                        </x-nav-link>

                        <x-nav-link :href="route('news.index')" :active="request()->routeIs('news.*')">
                            {{ __('News') }}
                        </x-nav-link>

                        <x-nav-link :href="route('faq.index')" :active="request()->routeIs('faq.*')">
                            {{ __('FAQ') }}
                        </x-nav-link>

                        <x-nav-link :href="route('contact.show')" :active="request()->routeIs('contact.*')">
                            {{ __('Contact') }}
                        </x-nav-link>
                    @else
                        <x-nav-link :href="url('/')" :active="request()->is('/')">
                            {{ __('Home') }}
                        </x-nav-link>

                        <x-nav-link :href="route('news.index')" :active="request()->routeIs('news.*')">
                            {{ __('News') }}
                        </x-nav-link>

                        <x-nav-link :href="route('faq.index')" :active="request()->routeIs('faq.*')">
                            {{ __('FAQ') }}
                        </x-nav-link>

                        <x-nav-link :href="route('contact.show')" :active="request()->routeIs('contact.*')">
                            {{ __('Contact') }}
                        </x-nav-link>
                    @endauth
                </div>
            </div>

            <!-- Settings Dropdown / Auth Links -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                @auth
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-lg text-slate-600 bg-white hover:text-emerald-700 focus:outline-none transition ease-in-out duration-150">
                                <div>{{ auth()->user()?->name }}</div>

                                <div class="ms-1">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <x-dropdown-link :href="route('profile.edit')">
                                {{ __('Profile') }}
                            </x-dropdown-link>

                            <!-- Authentication -->
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf

                                <x-dropdown-link :href="route('logout')"
                                        onclick="event.preventDefault();
                                                    this.closest('form').submit();">
                                    {{ __('Log Out') }}
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                @else
                    <div class="flex items-center gap-4">
                        <a class="text-sm text-slate-600 hover:text-emerald-700" href="{{ route('login') }}">
                            {{ __('Login') }}
                        </a>
                        @if (Route::has('register'))
                            <a class="text-sm text-slate-600 hover:text-emerald-700" href="{{ route('register') }}">
                                {{ __('Register') }}
                            </a>
                        @endif
                    </div>
                @endauth
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-slate-400 hover:text-emerald-700 hover:bg-emerald-50 focus:outline-none focus:bg-emerald-50 focus:text-emerald-700 transition duration-150 ease-in-out">
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
            @auth
                <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                    {{ __('Dashboard') }}
                </x-responsive-nav-link>

                <x-responsive-nav-link :href="route('news.index')" :active="request()->routeIs('news.*')">
                    {{ __('News') }}
                </x-responsive-nav-link>

                <x-responsive-nav-link :href="route('faq.index')" :active="request()->routeIs('faq.*')">
                    {{ __('FAQ') }}
                </x-responsive-nav-link>

                <x-responsive-nav-link :href="route('contact.show')" :active="request()->routeIs('contact.*')">
                    {{ __('Contact') }}
                </x-responsive-nav-link>
            @else
                <x-responsive-nav-link :href="url('/')" :active="request()->is('/')">
                    {{ __('Home') }}
                </x-responsive-nav-link>

                <x-responsive-nav-link :href="route('news.index')" :active="request()->routeIs('news.*')">
                    {{ __('News') }}
                </x-responsive-nav-link>

                <x-responsive-nav-link :href="route('faq.index')" :active="request()->routeIs('faq.*')">
                    {{ __('FAQ') }}
                </x-responsive-nav-link>

                <x-responsive-nav-link :href="route('contact.show')" :active="request()->routeIs('contact.*')">
                    {{ __('Contact') }}
                </x-responsive-nav-link>
            @endauth
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-slate-200">
            @auth
                <div class="px-4">
                    <div class="font-medium text-base text-slate-800">{{ auth()->user()?->name }}</div>
                    <div class="font-medium text-sm text-slate-500">{{ auth()->user()?->email }}</div>
                </div>

                <div class="mt-3 space-y-1">
                    <x-responsive-nav-link :href="route('profile.edit')">
                        {{ __('Profile') }}
                    </x-responsive-nav-link>

                    <!-- Authentication -->
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf

                        <x-responsive-nav-link :href="route('logout')"
                                onclick="event.preventDefault();
                                            this.closest('form').submit();">
                            {{ __('Log Out') }}
                        </x-responsive-nav-link>
                    </form>
                </div>
            @else
                <div class="px-4">
                    <div class="font-medium text-base text-slate-800">{{ __('Guest') }}</div>
                </div>

                <div class="mt-3 space-y-1">
                    <x-responsive-nav-link :href="route('login')">
                        {{ __('Login') }}
                    </x-responsive-nav-link>

                    @if (Route::has('register'))
                        <x-responsive-nav-link :href="route('register')">
                            {{ __('Register') }}
                        </x-responsive-nav-link>
                    @endif
                </div>
            @endauth
        </div>
    </div>
</nav>
