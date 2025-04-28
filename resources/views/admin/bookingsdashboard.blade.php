<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="icon" href="{{ asset('images/saaslogo.png') }}" type="image/png">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bookings Dashboard</title>
    <script src="{{ asset('js/sweetalert2.all.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.5/flowbite.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>
    <script src="{{ asset('js/toprightalert.js') }}"></script>



    <style>
        
        .fc-toolbar-title {
            font-size: 1.75rem;
        }

        @media (max-width: 768px) { 
            .fc-toolbar-title {
                font-size: 1.3rem;
            }
        }

        @media (max-width: 480px) { 
            .fc-toolbar-title {
                font-size: 1.1rem;
            }
        }

        
        .fc-button {
            font-size: 1rem;
            padding: 0.4rem 0.8rem;
            margin: 0 0.2rem; 
        }

        @media (max-width: 768px) {
            .fc-button {
                font-size: 0.875rem;
                padding: 0.35rem 0.7rem;
            }
        }

        @media (max-width: 480px) {
            .fc-button {
                font-size: 0.75rem;
                padding: 0.25rem 0.6rem;
            }
        }

        
        .fc-header-toolbar {
            flex-wrap: wrap;
            gap: 0.5rem;
        }

        
        .fc-daygrid-day-number {
            font-size: 1rem;
        }

        @media (max-width: 768px) {
            .fc-daygrid-day-number {
                font-size: 0.875rem;
            }
        }

        @media (max-width: 480px) {
            .fc-daygrid-day-number {
                font-size: 0.75rem;
            }
        }

        .fc-event {
            font-size: 0.875rem;
        }

        @media (max-width: 768px) {
            .fc-event {
                font-size: 0.75rem;
            }
        }

        @media (max-width: 480px) {
            .fc-event {
                font-size: 0.625rem;
            }
        }
    </style>

    <script>
        function confirmDelete(form) {
            event.preventDefault();

            Swal.fire({
                title: 'Are you sure?',
                text: "This order will be permanently deleted!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });

            return false;
        }

        function confirmAction(message, event) {
            event.preventDefault();

            Swal.fire({
                title: 'Are you sure?',
                text: message,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, proceed!'
            }).then((result) => {
                if (result.isConfirmed) {
                    event.target.submit();
                }
            });

            return false;
        }
    </script>
</head>

<body>
    @if (session('success'))
        <script>
            showSuccessToast('{{ session('success') }}');
        </script>
    @endif

    @if (session('error'))
        <script>
            showErrorToast('{{ session('error') }}');
        </script>
    @endif

    <div class="flex h-screen">

        {{-- SIDENAV --}}

        <x-dashboard.side-nav />



        {{-- END SIDENAV --}}


        <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-100 p-6 border">


            <div class="container mx-auto px-4 py-8 ">
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8 ">
                    <h1 class="text-3xl font-bold text-gray-800 mb-4 sm:mb-0 ">All Bookings</h1>
                    <div class="flex space-x-3">
                        <!-- Refresh -->
                        <a href="{{ route('admin.bookings') }}"
                            class="inline-flex items-center px-4 py-2 bg-gray-100 border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-200 active:bg-gray-300 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 transition ease-in-out duration-150">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15">
                                </path>
                            </svg>
                            Refresh
                        </a>
                        {{-- <button onclick="window.print()"
                            class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 transition ease-in-out duration-150">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z">
                                </path>
                            </svg>
                            Print
                        </button> --}}

                        <!-- Export -->
                        <button
                            class="hover:cursor-pointer inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs hover:bg-gray-200 text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                </path>
                            </svg>
                            Export
                        </button>
                    </div>
                </div>


                <!-- Filter Section -->

                <!-- Filter Section -->
                <div class="flex items-center space-x-4 mb-4">
                    <!-- Status Filter -->
                    <div class="flex items-center space-x-2">
                        <label for="status" class="text-sm text-gray-600">Status:</label>
                        <form id="statusForm" method="GET" action="{{ request()->url() }}"
                            class="flex items-center space-x-2">
                            <select id="status" name="status"
                                class="text-sm border border-gray-300 rounded px-2 py-1 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                onchange="this.form.submit()">
                                <option value="">All</option>
                                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending
                                </option>
                                <option value="partial" {{ request('status') == 'partial' ? 'selected' : '' }}>Partially
                                    Paid</option>
                                <option value="ongoing" {{ request('status') == 'ongoing' ? 'selected' : '' }}>Ongoing
                                </option>
                                <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>
                                    Completed</option>
                                <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>
                                    Cancelled</option>
                            </select>
                        </form>
                    </div>

                    <!-- Entries Per Page -->
                    <div class="flex items-center space-x-2">
                        <form id="entriesForm" method="GET" action="{{ request()->url() }}"
                            class="flex items-center space-x-2">
                            <label for="entries" class="text-sm text-gray-600">Show:</label>
                            <select id="entries" name="entries"
                                class="text-sm border border-gray-300 rounded px-2 py-1 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                onchange="this.form.submit()">
                                <option value="5" {{ $perPage == 5 ? 'selected' : '' }}>5</option>
                                <option value="10" {{ $perPage == 10 ? 'selected' : '' }}>10</option>
                                <option value="15" {{ $perPage == 15 ? 'selected' : '' }}>15</option>
                                <option value="20" {{ $perPage == 20 ? 'selected' : '' }}>20</option>
                                <option value="25" {{ $perPage == 25 ? 'selected' : '' }}>25</option>
                            </select>
                            <span class="text-sm text-gray-600">entries</span>

                            <!-- Preserve any existing query parameters -->
                            @foreach (request()->except(['entries', 'page']) as $key => $value)
                                <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                            @endforeach
                        </form>
                    </div>

                    <!-- Search Box -->
                    <div class="w-full sm:w-auto">
                        <form method="GET" action="{{ request()->url() }}">
                            <div class="flex">
                                <input type="text" name="search" placeholder="Search..."
                                    value="{{ $search }}"
                                    class="w-full sm:w-64 text-sm border border-gray-300 rounded-l px-3 py-1 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <button type="submit"
                                    class="bg-blue-500 text-white px-3 py-1 rounded-r hover:bg-blue-600 text-sm">
                                    Search
                                </button>
                            </div>

                            <!-- Preserve entries parameter -->
                            <input type="hidden" name="entries" value="{{ $perPage }}">

                            <!-- Preserve sort parameters -->
                            <input type="hidden" name="sort" value="{{ $sortColumn }}">
                            <input type="hidden" name="direction" value="{{ $sortDirection }}">

                            <!-- Preserve any other existing query parameters -->
                            @foreach (request()->except(['search', 'page', 'entries', 'sort', 'direction']) as $key => $value)
                                <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                            @endforeach
                        </form>
                    </div>
                </div>

                @if ($orders->isEmpty())
                    <!-- Empty State -->
                    <div class="bg-white rounded-lg shadow p-12 text-center">
                        <svg class="w-20 h-20 mx-auto text-gray-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01">
                            </path>
                        </svg>
                        <h3 class="mt-4 text-xl font-medium text-gray-900">No bookings found</h3>

                        <div class="mt-6">
                            <a href="{{ route('admin.bookings') }}"
                                class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:border-indigo-900 focus:ring ring-indigo-300 transition ease-in-out duration-150">
                                Reset Filters
                            </a>
                        </div>
                    </div>
                @else
                    {{-- <div class="bg-white rounded-lg shadow overflow-hidden"> --}}




                    <div class=" px-4 sm:px-6 lg:px-8 overflow-x-auto ">
                        <table id="ordersTable" class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col"
                                        class="px-3 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden sm:table-cell">
                                        <a href="{{ request()->fullUrlWithQuery(['sort' => 'id', 'direction' => $sortColumn == 'id' && $sortDirection == 'asc' ? 'desc' : 'asc']) }}"
                                            class="flex items-center group">
                                            Order ID
                                            @if ($sortColumn == 'id')
                                                <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                    @if ($sortDirection == 'asc')
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="M5 15l7-7 7 7"></path>
                                                    @else
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                                    @endif
                                                </svg>
                                            @else
                                                <svg class="w-4 h-4 ml-1 opacity-0 group-hover:opacity-50"
                                                    fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2" d="M5 15l7-7 7 7"></path>
                                                </svg>
                                            @endif
                                        </a>
                                    </th>

                                    {{-- CUSTOMER COL --}}
                                    <th scope="col"
                                        class="px-3 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        <a href="{{ request()->fullUrlWithQuery(['sort' => 'user_first_name', 'direction' => $sortColumn == 'user_first_name' && $sortDirection == 'asc' ? 'desc' : 'asc']) }}"
                                            class="flex items-center group">
                                            Customer
                                            @if ($sortColumn == 'user_first_name')
                                                <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                    @if ($sortDirection == 'asc')
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="M5 15l7-7 7 7"></path>
                                                    @else
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                                    @endif
                                                </svg>
                                            @else
                                                <svg class="w-4 h-4 ml-1 opacity-0 group-hover:opacity-50"
                                                    fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2" d="M5 15l7-7 7 7"></path>
                                                </svg>
                                            @endif
                                        </a>
                                    </th>

                                    {{-- EVENT DETAILS --}}
                                    <th scope="col"
                                        class="px-3 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden sm:table-cell">
                                        <a href="{{ request()->fullUrlWithQuery(['sort' => 'event_date_start', 'direction' => $sortColumn == 'event_date_start' && $sortDirection == 'asc' ? 'desc' : 'asc']) }}"
                                            class="flex items-center group">
                                            Event Details
                                            @if ($sortColumn == 'event_date_start')
                                                <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                    @if ($sortDirection == 'asc')
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="M5 15l7-7 7 7"></path>
                                                    @else
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                                    @endif
                                                </svg>
                                            @else
                                                <svg class="w-4 h-4 ml-1 opacity-0 group-hover:opacity-50"
                                                    fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2" d="M5 15l7-7 7 7"></path>
                                                </svg>
                                            @endif
                                        </a>
                                    </th>

                                    {{-- AMOUNT PAID --}}
                                    <th scope="col"
                                        class="px-3 sm:px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider hidden sm:table-cell">
                                        <a href="{{ request()->fullUrlWithQuery(['sort' => 'amount_paid', 'direction' => $sortColumn == 'amount_paid' && $sortDirection == 'asc' ? 'desc' : 'asc']) }}"
                                            class="flex items-center justify-end group">
                                            Amount Paid
                                            @if ($sortColumn == 'amount_paid')
                                                <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                    @if ($sortDirection == 'asc')
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="M5 15l7-7 7 7"></path>
                                                    @else
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                                    @endif
                                                </svg>
                                            @else
                                                <svg class="w-4 h-4 ml-1 opacity-0 group-hover:opacity-50"
                                                    fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2" d="M5 15l7-7 7 7"></path>
                                                </svg>
                                            @endif
                                        </a>
                                    </th>
                                    {{-- TOTAL --}}
                                    <th scope="col"
                                        class="px-3 sm:px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider hidden sm:table-cell">
                                        <a href="{{ request()->fullUrlWithQuery(['sort' => 'total', 'direction' => $sortColumn == 'total' && $sortDirection == 'asc' ? 'desc' : 'asc']) }}"
                                            class="flex items-center justify-end group">
                                            Total
                                            @if ($sortColumn == 'total')
                                                <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                    @if ($sortDirection == 'asc')
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="M5 15l7-7 7 7"></path>
                                                    @else
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                                    @endif
                                                </svg>
                                            @else
                                                <svg class="w-4 h-4 ml-1 opacity-0 group-hover:opacity-50"
                                                    fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2" d="M5 15l7-7 7 7"></path>
                                                </svg>
                                            @endif
                                        </a>
                                    </th>
                                    {{-- REMAINING BALANCE --}}
                                    <th scope="col"
                                        class="px-3 sm:px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider hidden sm:table-cell">
                                        Remaining Balance
                                    </th>
                                    {{-- PARTIAL PAYMENT --}}
                                    <th scope="col"
                                        class="px-3 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Partial Payment Date
                                    </th>
                                    {{-- status --}}
                                    <th scope="col"
                                        class="px-3 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        <a href="{{ request()->fullUrlWithQuery(['sort' => 'status', 'direction' => $sortColumn == 'status' && $sortDirection == 'asc' ? 'desc' : 'asc']) }}"
                                            class="flex items-center group">
                                            Status
                                            @if ($sortColumn == 'status')
                                                <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                    @if ($sortDirection == 'asc')
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="M5 15l7-7 7 7"></path>
                                                    @else
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                                    @endif
                                                </svg>
                                            @else
                                                <svg class="w-4 h-4 ml-1 opacity-0 group-hover:opacity-50"
                                                    fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2" d="M5 15l7-7 7 7"></path>
                                                </svg>
                                            @endif
                                        </a>
                                    </th>
                                    <th scope="col"
                                        class="px-3 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Actions
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach ($orders as $order)
                                    <tr class="hover:bg-gray-50 transition-colors"
                                        data-status="{{ strtolower($order->status) }}"
                                        data-date="{{ \Carbon\Carbon::parse($order->event_date)->format('Y-m-d') }}">
                                        <!-- Order ID (hidden on mobile) -->
                                        <td class="px-3 sm:px-6 py-4 whitespace-nowrap hidden sm:table-cell">
                                            <a href="{{ route('order.show', $order->id) }}"
                                                class="hover:underline text-sm font-medium text-gray-900">
                                                #{{ $order->id }}
                                            </a>
                                            <div class="text-xs text-gray-500">
                                                {{ $order->created_at->format('M d, Y') }}
                                            </div>
                                        </td>

                                        <!-- Customer Info (always visible) -->
                                        <td class="px-3 sm:px-6 py-4">
                                            <div class="flex items-center gap-3">
                                                <div>
                                                    <div class="text-sm font-medium text-gray-900">
                                                        {{ $order->user->first_name }}
                                                    </div>
                                                    <div class="text-xs text-gray-500">{{ $order->user->email }}</div>
                                                </div>
                                            </div>
                                        </td>

                                        <!-- Event Details (hidden on mobile) -->
                                        <td class="px-3 sm:px-6 py-4 hidden sm:table-cell">
                                            <div class="text-sm font-medium text-gray-900">
                                                {{ $order->event_type }}
                                            </div>
                                            <div class="flex items-center text-xs text-gray-500 mt-1">
                                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                                    </path>
                                                </svg>
                                                {{ \Carbon\Carbon::parse($order->event_date_start)->format('M d, Y') }}
                                                @if ($order->event_date_start != $order->event_date_end)
                                                    -
                                                    {{ \Carbon\Carbon::parse($order->event_date_end)->format('M d, Y') }}
                                                @endif
                                            </div>
                                        </td>

                                        <!-- Amount Paid (hidden on mobile) -->
                                        <td
                                            class="px-3 sm:px-6 py-4 whitespace-nowrap text-right hidden sm:table-cell">
                                            <div class="text-sm font-medium text-gray-900">
                                                ₱{{ number_format($order->amount_paid, 2) }}
                                            </div>
                                        </td>

                                        <!-- Total (hidden on mobile) -->
                                        <td
                                            class="px-3 sm:px-6 py-4 whitespace-nowrap text-right hidden sm:table-cell">
                                            <div class="text-sm font-medium text-gray-900">
                                                ₱{{ number_format($order->total, 2) }}
                                            </div>
                                        </td>

                                        <!-- Remaining Balance (hidden on mobile) -->
                                        <td
                                            class="px-3 sm:px-6 py-4 whitespace-nowrap text-right hidden sm:table-cell">
                                            <div class="text-sm font-medium text-gray-900">
                                                ₱{{ number_format($order->total - $order->amount_paid, 2) }}
                                            </div>
                                        </td>

                                        <!-- Partial Payment Date -->
                                        <td class="px-3 sm:px-6 py-4 whitespace-nowrap">
                                            @if ($order->partial_payment_date)
                                                <div class="text-sm font-medium text-gray-900">
                                                    {{ \Carbon\Carbon::parse($order->partial_payment_date)->format('M d, Y') }}
                                                </div>
                                            @else
                                                <div class="text-sm text-gray-500">N/A</div>
                                            @endif
                                        </td>

                                        <!-- Status (always visible) -->
                                        <td class="px-3 sm:px-6 py-4 whitespace-nowrap">
                                            <span
                                                class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $order->bgColor }} {{ $order->textColor }}">
                                                {{ ucfirst($order->status) }}
                                            </span>
                                            <!-- Mobile financial summary -->
                                            <div class="sm:hidden mt-2 space-y-1">
                                                <div class="text-xs text-gray-500 flex justify-between">
                                                    <span>Paid:</span>
                                                    <span
                                                        class="font-medium">₱{{ number_format($order->amount_paid, 2) }}</span>
                                                </div>
                                                <div class="text-xs text-gray-500 flex justify-between">
                                                    <span>Total:</span>
                                                    <span
                                                        class="font-medium">₱{{ number_format($order->total, 2) }}</span>
                                                </div>
                                                <div class="text-xs text-gray-500 flex justify-between">
                                                    <span>Remaining Balance:</span>
                                                    <span
                                                        class="font-medium">₱{{ number_format($order->total - $order->amount_paid, 2) }}</span>
                                                </div>
                                            </div>
                                        </td>

                                        <!-- Actions (always visible) -->
                                        <td class="px-3 sm:px-6 py-4 whitespace-nowrap">
                                            <select class="form-control form-select"
                                                id="action-select-{{ $order->id }}"
                                                onchange="executeOrderAction(this, {{ $order->id }})">
                                                <option value="">Actions</option>
                                                <option value="invoice">Invoice</option>

                                                @if ($order->status !== 'ongoing' && $order->status !== 'cancelled' && $order->status !== 'paid')
                                                    <option value="ongoing">Set Ongoing</option>
                                                @endif

                                                @if ($order->status !== 'cancelled' && $order->status !== 'paid')
                                                    <option value="partial">Partial Payment</option>
                                                @endif

                                                @if (!$order->paid)
                                                    <option value="paid">Mark Paid</option>
                                                @else
                                                    <option value="unpaid">Mark Unpaid</option>
                                                @endif

                                                @if ($order->status !== 'completed' && $order->status !== 'cancelled')
                                                    <option value="completed">Mark Completed</option>
                                                @endif

                                                @if ($order->status != 'cancelled')
                                                    <option value="cancel">Cancel Order</option>
                                                @endif

                                                <option value="penalty">Add Penalty</option>
                                                <option value="delete">Delete</option>
                                            </select>

                                            <!-- Hidden action buttons -->
                                            <div class="hidden">
                                                <span id="invoice-btn-{{ $order->id }}"><x-actions.invoice-button
                                                        :order="$order" /></span>
                                                <span id="ongoing-btn-{{ $order->id }}"><x-actions.ongoing-button
                                                        :order="$order" /></span>
                                                <span id="partial-btn-{{ $order->id }}"><x-actions.partial-button
                                                        :order="$order" /></span>
                                                <span id="paid-btn-{{ $order->id }}"><x-actions.paid-button
                                                        :order="$order" /></span>
                                                <span id="unpaid-btn-{{ $order->id }}"><x-actions.unpaid-button
                                                        :order="$order" /></span>
                                                <span
                                                    id="completed-btn-{{ $order->id }}"><x-actions.completed-button
                                                        :order="$order" /></span>
                                                <span id="cancel-btn-{{ $order->id }}"><x-actions.cancel-button
                                                        :order="$order" /></span>
                                                <span id="penalty-btn-{{ $order->id }}"><x-actions.penalty-button
                                                        :order="$order" /></span>
                                                <span id="delete-btn-{{ $order->id }}"><x-actions.delete-button
                                                        :order="$order" /></span>
                                            </div>

                                            <script>
                                                function executeOrderAction(selectElement, orderId) {
                                                    const action = selectElement.value;
                                                    if (!action) return;



                                                    // For all other actions, find the respective button and click it
                                                    const buttonContainer = document.getElementById(`${action}-btn-${orderId}`);
                                                    if (buttonContainer) {
                                                        const button = buttonContainer.querySelector('button');
                                                        if (button) {
                                                            button.click();
                                                        }
                                                    }

                                                    // Reset the select
                                                    selectElement.selectedIndex = 0;
                                                }
                                            </script>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <p id="noResultsMessage" style="display: none;">No orders found for this filter.</p>

                    </div>

                    
                    <!-- Pagination -->
                    @if ($orders->hasPages())
                        <div class="px-4 sm:px-6 py-4 border-t border-gray-200 bg-gray-50">
                            <div class="flex items-end gap-5 justify-end">
                                <!-- Showing results text on the left -->
                                {{-- <div class="text-sm text-gray-700">
                                    Showing <span class="font-medium">{{ $orders->firstItem() }}</span> to <span
                                        class="font-medium">{{ $orders->lastItem() }}</span> of <span
                                        class="font-medium">{{ $orders->total() }}</span> results
                                </div> --}}

                                <!-- Pagination links on the right -->
                                <div>
                                    {{ $orders->appends(request()->except('page'))->onEachSide(1)->links('pagination::tailwind') }}
                                </div>
                            </div>
                        </div>
                    @endif
                    
                    
                    {{-- </div> --}}
                @endif

                {{-- CALENDAR EVENTS --}}
                @php
                    use Carbon\Carbon;
                    $calendarEvents = $orders
                        // SORT CALENDAR FORMAT PARA MAUNA UNG NKA BASED SA TIME
                        ->sortBy(function ($order) {
                            // Parse the full datetime (date + time) for accurate sorting
                            return Carbon::parse($order->event_date_start . ' ' . $order->event_start_time)->timestamp;
                        })

                        ->map(function ($order) {
                            $status = strtolower($order->status);
                            // Set default color to blue
                            $color = '#3b82f6';
                            if ($status === 'pending') {
                                $color = '#FBBF24'; // Amber
                            } elseif ($status === 'partially paid') {
                                $color = '#F59E0B'; // Orange
                            } elseif ($status === 'ongoing') {
                                $color = '#60A5FA'; // Light blue
                            } elseif ($status === 'paid') {
                                $color = '#10B981'; // Green
                            } elseif ($status === 'completed') {
                                $color = '#34D399'; // Light green
                            } elseif ($status === 'cancelled') {
                                $color = '#EF4444'; // Red
                            }
                            // Parse start date and time properly
                            return [
                                'title' => $order->event_type, // e.g., "Birthday"
                                'start' => $order->event_date_start, // Format: YYYY-MM-DD

                                'end' => Carbon::parse($order->event_date_end)->addDay()->toDateString(),
                                'start_time' => $order->event_start_time,
                                'end_time' => $order->event_start_end,
                                'status' => $order->status,
                                'backgroundColor' => $color,
                                'borderColor' => $color,
                            ];
                        })
                        ->values()
                        ->toArray();
                @endphp


                {{-- CALENDAR BOOKINGS --}}
                <div class="container mx-auto px-4 py-6 sm:py-8 ">
                    <div class="max-w-6xl mx-auto">
                        <h1 class="text-2xl sm:text-3xl font-bold text-gray-800 mb-4 sm:mb-6 text-center font-serif">
                            Event Calendar
                        </h1>

                        <!-- Calendar Container -->
                        <div class="bg-white shadow-lg rounded-lg overflow-hidden border border-gray-200">
                            <div id="calendar"
                                class="p-3 sm:p-4 md:p-6 min-h-[480px] sm:min-h-[600px] md:min-h-[680px]"></div>
                        </div>
                    </div>
                </div>

            </div>


        </main>

    </div>
    {{-- BOOKING CALENDAR JS --}}
    <script>
        window.calendarEvents = @json($calendarEvents);
    </script>
    <script src="{{ asset('js/calendar-event-booking.js') }}"></script>

    {{-- BOOKING FILTER --}}
    {{-- <script src="{{ asset('js/filter-booking.js') }}"></script> --}}


</body>

</html>
