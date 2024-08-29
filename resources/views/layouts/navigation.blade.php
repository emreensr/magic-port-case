<!-- resources/views/navigation.blade.php -->
<nav class="bg-white border-b border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16 items-center">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <x-application-logo class="block h-9 w-auto fill-current text-gray-800" />
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        {{ __('Dashboard') }}
                    </x-nav-link>
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <div class="relative flex items-center gap-2">
                    <!-- Dropdown Trigger -->
                    <div class="border p-2 text-sm rounded-md">{{ Auth::user()->name }}</div>

                    <form method="POST" action="{{ route('logout') }}"
                        class="block px-4 py-2 text-gray-700 hover:bg-gray-100">
                        @csrf
                        <button type="submit" class="w-full text-sm text-white bg-red-500 p-2 rounded-lg">
                            {{ __('Log Out') }}
                        </button>
                    </form>
                </div>
            </div>

            <!-- Responsive Settings Options -->
            <div class="pt-4 pb-1 border-t border-gray-200 mb-5 sm:hidden">
                <form method="POST" action="{{ route('logout') }}"
                    class="block px-4 py-2 text-gray-700 hover:bg-gray-100">
                    @csrf
                    <button type="submit" class="w-24 text-center text-white text-left bg-red-500 p-2 rounded-lg">
                        {{ __('Log Out') }}
                    </button>
                </form>
            </div>
        </div>
    </div>
</nav>
