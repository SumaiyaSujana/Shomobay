<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Shomobay Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-2xl font-bold mb-4 text-green-700">Welcome back, {{ auth()->user()->name }}! 👋</h3>
                    
                    <p class="mb-8 text-gray-600">What would you like to do today?</p>

                    <div class="flex flex-wrap gap-4">
                        
                        @if(auth()->user()->role === 'admin')
                            <a href="/admin/dashboard" class="bg-purple-600 hover:bg-purple-700 text-white font-bold py-3 px-6 rounded-lg shadow-md transition duration-300">
                                👑 Go to Admin Panel
                            </a>
                        @endif

                        <a href="/vendor/dashboard" class="bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-3 px-6 rounded-lg shadow-md transition duration-300">
                            🏪 Vendor Portal
                        </a>

                        <a href="/" class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold py-3 px-6 rounded-lg shadow-md transition duration-300">
                            🏠 Back to Homepage
                        </a>

                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>