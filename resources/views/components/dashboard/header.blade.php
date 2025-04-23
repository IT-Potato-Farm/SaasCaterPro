<header class="bg-white shadow-sm">
    <div class="flex items-center justify-between p-4">
        <div>
            <h1 class="text-xl font-semibold text-gray-800">ADMIN DASHBOARD</h1>
            @auth
                @if (Auth::user()->role === 'admin')
                    <p class="text-sm text-gray-600">Welcome, {{ Auth::user()->first_name }}</p>
                @endif
            @endauth
        </div>
        <form action="{{route('logout')}}" method="post">
            @csrf
            <button class="px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600">
                Logout
            </button>
        </form>
    </div>
</header>