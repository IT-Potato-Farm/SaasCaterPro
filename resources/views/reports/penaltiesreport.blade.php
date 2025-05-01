<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PENALTIES</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.5/flowbite.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* Adjustments for print layout */
        @media print {
            .print:hidden {
                display: none !important;
            }
            
            /* Header Style for Print */
            #print-header {
                display: block !important;
                margin-bottom: 20px;
            }
            
            /* Card adjustments for print */
            .grid {
                display: grid !important;
                grid-template-columns: 1fr !important;
                gap: 10px;
            }
    
            .bg-white {
                background-color: #fff !important;
            }
    
            .text-center {
                text-align: center !important;
            }
    
            .p-4 {
                padding: 10px !important;
            }
    
            .text-sm {
                font-size: 12px !important;
            }
    
            .text-xs {
                font-size: 10px !important;
            }
    
            /* Table adjustments */
            table {
                width: 100% !important;
                border-collapse: collapse;
            }
    
            th, td {
                padding: 8px !important;
                text-align: left !important;
                border: 1px solid #ddd !important;
            }
    
            .hover\:bg-gray-50:hover {
                background-color: transparent !important;
            }
    
            /* Hide action buttons on print */
            /* .text-blue-600, .text-indigo-600, .text-red-600 {
                display: none !important;
            } */
    
            /* Optional: Adjust pagination buttons if necessary */
            .pagination {
                display: none !important;
            }
        }
    </style>
</head>

<body>
    <div class="flex h-screen">
        {{-- SIDENAV --}}
        <x-dashboard.side-nav />
        {{-- END SIDENAV --}}

        <div class="flex-1 flex flex-col overflow-hidden">
            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-100 p-6">
                <!-- Penalty Reports Page -->
                <div class="container mx-auto">
                    <!-- Page Header -->
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6 print:hidden">
                        <h1 class="text-2xl font-semibold text-gray-800">Penalty Reports</h1>
                        <button onclick="window.print()" class="mt-4 md:mt-0 px-4 py-2 text-white bg-blue-600 rounded-md shadow-md hover:bg-blue-700 focus:outline-none">
                            Print Report
                        </button>
                       
                    </div>

                    <!-- Filters Section -->
                    <div class="bg-white rounded-lg shadow-md p-4 mb-6 print:hidden">
                        <h2 class="text-lg font-medium text-gray-700 mb-4">Filters</h2>
                        <form action=" {{ request()->url() }}" method="GET"
                            class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                            {{-- <div class="flex flex-col">
                                <label for="order_id" class="text-sm font-medium text-gray-700 mb-1">Order ID</label>
                                <input type="text" name="order_id" id="order_id" value="{{ request('order_id') }}"
                                    class="border border-gray-300 rounded-md shadow-sm px-3 py-2 focus:outline-none focus:ring-1 focus:ring-blue-500">
                            </div> --}}
                            <div class="flex flex-col">
                                <label for="min_amount" class="text-sm font-medium text-gray-700 mb-1">Min
                                    Amount</label>
                                <input type="number" name="min_amount" id="min_amount"
                                    value="{{ request('min_amount') }}"
                                    class="border border-gray-300 rounded-md shadow-sm px-3 py-2 focus:outline-none focus:ring-1 focus:ring-blue-500">
                            </div>
                            <div class="flex flex-col">
                                <label for="max_amount" class="text-sm font-medium text-gray-700 mb-1">Max
                                    Amount</label>
                                <input type="number" name="max_amount" id="max_amount"
                                    value="{{ request('max_amount') }}"
                                    class="border border-gray-300 rounded-md shadow-sm px-3 py-2 focus:outline-none focus:ring-1 focus:ring-blue-500">
                            </div>
                            <div class="flex flex-col">
                                <label for="reason" class="text-sm font-medium text-gray-700 mb-1">Reason</label>
                                <input type="text" name="reason" id="reason" value="{{ request('reason') }}"
                                    class="border border-gray-300 rounded-md shadow-sm px-3 py-2 focus:outline-none focus:ring-1 focus:ring-blue-500">
                            </div>
                            <div class="flex flex-col md:col-span-2 lg:col-span-4">
                                <div class="flex flex-col sm:flex-row gap-3">
                                    <button type="submit"
                                        class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md text-sm font-medium transition duration-150 ease-in-out">
                                        Apply Filters
                                    </button>
                                    <a href="{{ route('admin.reports.penalties') }}"
                                        class="bg-gray-200 hover:bg-gray-300 text-gray-800 px-4 py-2 rounded-md text-sm font-medium transition duration-150 ease-in-out text-center">
                                        Clear Filters
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>



                    <div id="print-header" class="print-header hidden   text-center p-4  ">
                        <h1 class="text-xl font-bold uppercase">SAAS Food & Catering Services</h1>
                        <p class="mt-1 text-xs">Penalty Report
                        </p>
                        <p class="mt-1 text-xs">
                            @if (request('start_date') && request('end_date'))
                                {{ \Carbon\Carbon::parse(request('start_date'))->format('M d, Y') }} to
                                {{ \Carbon\Carbon::parse(request('end_date'))->format('M d, Y') }}
                            @else
                                All Dates
                            @endif
                        </p>
                        <p class="mt-1 text-xs">Generated: {{ now()->format('M d, Y h:i A') }}</p>
                    </div>
                    <!-- Stats Cards -->
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-6 print:hidden">
                        <div class="bg-white rounded-lg shadow-md p-6">
                            <div class="flex items-center">
                                <div class="p-3 rounded-full bg-blue-100 text-blue-600">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2z" />
                                    </svg>
                                </div>
                                <div class="ml-4">
                                    <h2 class="text-sm font-medium text-gray-500">Total Penalties</h2>
                                    <p class="text-2xl font-semibold text-gray-800">{{ $totalCount ?? 0 }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="bg-white rounded-lg shadow-md p-6">
                            <div class="flex items-center">
                                <div class="p-3 rounded-full bg-green-100 text-green-600">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <div class="ml-4">
                                    <h2 class="text-sm font-medium text-gray-500">Total Amount</h2>
                                    <p class="text-2xl font-semibold text-gray-800">
                                        ₱{{ number_format($totalAmount ?? 0, 2) }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="bg-white rounded-lg shadow-md p-6">
                            <div class="flex items-center">
                                <div class="p-3 rounded-full bg-purple-100 text-purple-600">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                    </svg>
                                </div>
                                <div class="ml-4">
                                    <h2 class="text-sm font-medium text-gray-500">Average Penalty</h2>
                                    <p class="text-2xl font-semibold text-gray-800">
                                        ₱{{ number_format($averagePenalty ?? 0, 2) }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                   
                    <!-- Penalties Table -->
                    <div class="bg-white rounded-lg shadow-md overflow-hidden">
                        @if ($penalties->count() > 0)
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th scope="col"
                                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                ID
                                            </th>
                                            <th scope="col"
                                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Customer Name
                                            </th>
                                            <th scope="col"
                                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Order ID
                                            </th>
                                            <th scope="col"
                                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Amount
                                            </th>
                                            <th scope="col"
                                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Reason
                                            </th>
                                            <th scope="col"
                                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Created At
                                            </th>
                                            <th scope="col"
                                                class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider print:hidden">
                                                Actions
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @foreach ($penalties as $penalty)
                                            <tr class="hover:bg-gray-50">
                                                <td
                                                    class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                    {{ $penalty->id }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                    {{ $penalty->order && $penalty->order->user ? $penalty->order->user->first_name . ' ' . $penalty->order->user->last_name : 'N/A' }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                    <button onclick="viewOrder('{{ $penalty->order_id }}')"
                                                        class="text-blue-600 hover:text-blue-900">
                                                        #{{ $penalty->order_id }}
                                                    </button>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                    ₱{{ number_format($penalty->amount, 2) }}
                                                </td>
                                                <td class="px-6 py-4 text-sm text-gray-500 max-w-xs truncate">
                                                    {{ $penalty->reason }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                    {{ $penalty->created_at->format('M d, Y') }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium print:hidden">
                                                    <div class="flex justify-end space-x-2">
                                                        <button onclick="viewPenalty('{{ $penalty->id }}')"
                                                            class="text-blue-600 hover:text-blue-900">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
                                                                fill="none" viewBox="0 0 24 24"
                                                                stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                            </svg>
                                                        </button>
                                                        <button onclick="editPenalty('{{ $penalty->id }}')"
                                                            class="text-indigo-600 hover:text-indigo-900">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
                                                                fill="none" viewBox="0 0 24 24"
                                                                stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                            </svg>
                                                        </button>
                                                        <button onclick="deletePenalty('{{ $penalty->id }}')"
                                                            class="text-red-600 hover:text-red-900">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
                                                                fill="none" viewBox="0 0 24 24"
                                                                stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                            </svg>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <!-- Pagination -->
                            <div class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6">
                                {{ $penalties->links() }}
                            </div>
                        @else
                            <div class="text-center py-12">
                                <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto h-12 w-12 text-gray-400"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <h3 class="mt-2 text-sm font-medium text-gray-900">No penalties found</h3>
                                <p class="mt-1 text-sm text-gray-500">Get started by creating a new penalty.</p>
                                <div class="mt-6">
                                    <button id="emptyAddPenaltyBtn"
                                        class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                        <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg"
                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 4v16m8-8H4" />
                                        </svg>
                                        Add New Penalty
                                    </button>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </main>
        </div>
    </div>



    <script>
        const routes = {

            penaltyShow: '{{ route('api.penalties.show', ':id') }}',
            penaltyUpdate: '{{ route('api.penalties.update', ':id') }}',
            penaltyDestroy: '{{ route('api.penalties.destroy', ':id') }}',

        };
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Set up CSRF token for all AJAX requests
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            // Add Penalty button event listeners
            document.getElementById('addPenaltyBtn')?.addEventListener('click', function() {
                showAddPenaltyForm();
            });

            document.getElementById('emptyAddPenaltyBtn')?.addEventListener('click', function() {
                showAddPenaltyForm();
            });
        });



        /**
         * View penalty details
         * @param {string} id - Penalty ID
         */
        function viewPenalty(id) {
            const viewUrl = routes.penaltyShow.replace(':id', id);
            fetch(viewUrl, {
                    method: 'GET',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const penalty = data.data;
                        Swal.fire({
                            title: `Penalty Details #${penalty.id}`,
                            html: `
                        <div class="mt-3 text-left">
                            <div class="mb-4">
                                <span class="block text-gray-700 text-sm font-bold mb-1">Order ID:</span>
                                <span class="block text-gray-600">#${penalty.order_id}</span>
                            </div>
                            <div class="mb-4">
                                <span class="block text-gray-700 text-sm font-bold mb-1">Amount:</span>
                                <span class="block text-gray-600">₱${parseFloat(penalty.amount).toFixed(2)}</span>
                            </div>
                            <div class="mb-4">
                                <span class="block text-gray-700 text-sm font-bold mb-1">Reason:</span>
                                <span class="block text-gray-600">${penalty.reason}</span>
                            </div>
                            <div class="mb-4">
                                <span class="block text-gray-700 text-sm font-bold mb-1">Created At:</span>
                                <span class="block text-gray-600">${new Date(penalty.created_at).toLocaleDateString('en-US', { year: 'numeric', month: 'long', day: 'numeric' })}</span>
                            </div>
                            ${penalty.updated_at !== penalty.created_at ? `
                                    <div class="mb-4">
                                        <span class="block text-gray-700 text-sm font-bold mb-1">Last Updated:</span>
                                        <span class="block text-gray-600">${new Date(penalty.updated_at).toLocaleDateString('en-US', { year: 'numeric', month: 'long', day: 'numeric' })}</span>
                                    </div>
                                ` : ''}
                        </div>
                    `,
                            confirmButtonText: 'Close',
                            confirmButtonColor: '#3085d6'
                        });
                    } else {
                        Swal.fire({
                            title: 'Error!',
                            text: data.message || 'Failed to load penalty details.',
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    Swal.fire({
                        title: 'Error!',
                        text: 'Something went wrong. Please try again.',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                });
        }

        /**
         * Edit penalty
         * @param {string} id - Penalty ID
         */
        function editPenalty(id) {
            const editUrl = routes.penaltyUpdate.replace(':id', id);
            fetch(editUrl, {
                    method: 'GET',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const penalty = data.data;

                        Swal.fire({
                            title: 'Edit Penalty',
                            html: `
                        <form id="editPenaltyForm" class="mt-3 text-left">
                            <div class="mb-4">
                                <label for="edit_order_id" class="block text-gray-700 text-sm font-bold mb-2">Order ID:</label>
                                <input type="number" id="edit_order_id" name="order_id" value="${penalty.order_id}" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                            </div>
                            <div class="mb-4">
                                <label for="edit_amount" class="block text-gray-700 text-sm font-bold mb-2">Amount:</label>
                                <input type="number" step="0.01" id="edit_amount" name="amount" value="${penalty.amount}" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                            </div>
                            <div class="mb-4">
                                <label for="edit_reason" class="block text-gray-700 text-sm font-bold mb-2">Reason:</label>
                                <textarea id="edit_reason" name="reason" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" rows="3">${penalty.reason}</textarea>
                            </div>
                        </form>
                    `,
                            showCancelButton: true,
                            confirmButtonText: 'Update',
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            showLoaderOnConfirm: true,
                            focusConfirm: false,
                            preConfirm: () => {
                                const order_id = document.getElementById('edit_order_id').value;
                                const amount = document.getElementById('edit_amount').value;
                                const reason = document.getElementById('edit_reason').value;

                                if (!order_id || !amount || !reason) {
                                    Swal.showValidationMessage('All fields are required');
                                    return false;
                                }

                                return {
                                    order_id,
                                    amount,
                                    reason
                                };
                            },
                            allowOutsideClick: () => !Swal.isLoading()
                        }).then((result) => {
                            if (result.isConfirmed) {
                                updatePenalty(id, result.value);
                            }
                        });
                    } else {
                        Swal.fire({
                            title: 'Error!',
                            text: data.message || 'Failed to load penalty details.',
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    Swal.fire({
                        title: 'Error!',
                        text: 'Something went wrong. Please try again.',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                });
        }

        /**
         * Update a penalty via API
         * @param {string} id - Penalty ID
         * @param {Object} data - Updated penalty data
         */
        function updatePenalty(id, data) {
            const updateUrl = routes.penaltyUpdate.replace(':id', id);
            fetch(updateUrl, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify(data)
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire({
                            title: 'Success!',
                            text: 'Penalty updated successfully.',
                            icon: 'success',
                            confirmButtonText: 'OK'
                        }).then(() => {
                            window.location.reload();
                        });
                    } else {
                        Swal.fire({
                            title: 'Error!',
                            text: data.message || 'Failed to update penalty.',
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    Swal.fire({
                        title: 'Error!',
                        text: 'Something went wrong. Please try again.',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                });
        }

        /**
         * Delete a penalty
         * @param {string} id - Penalty ID
         */
        function deletePenalty(id) {
            Swal.fire({
                title: 'Are you sure?',
                text: "This penalty will be permanently deleted.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    const deleteUrl = routes.penaltyDestroy.replace(':id', id);
                    fetch(deleteUrl, {
                            method: 'DELETE',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                                    'content')
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                Swal.fire({
                                    title: 'Deleted!',
                                    text: 'Penalty has been deleted.',
                                    icon: 'success',
                                    confirmButtonText: 'OK'
                                }).then(() => {
                                    window.location.reload();
                                });
                            } else {
                                Swal.fire({
                                    title: 'Error!',
                                    text: data.message || 'Failed to delete penalty.',
                                    icon: 'error',
                                    confirmButtonText: 'OK'
                                });
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            Swal.fire({
                                title: 'Error!',
                                text: 'Something went wrong. Please try again.',
                                icon: 'error',
                                confirmButtonText: 'OK'
                            });
                        });
                }
            });
        }

        /**
         * View order details associated with a penalty
         * @param {string} orderId - Order ID
         */
        function viewOrder(orderId) {
            fetch(`{{ url('/api/orders') }}/${orderId}`, {
                    method: 'GET',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const order = data.data;

                        // Format order details for display
                        let orderDetails = `
                    <div class="mt-3 text-left">
                        <div class="mb-4">
                            <span class="block text-gray-700 text-sm font-bold mb-1">Order ID:</span>
                            <span class="block text-gray-600">#${order.id}</span>
                        </div>
                        <div class="mb-4">
                            <span class="block text-gray-700 text-sm font-bold mb-1">Customer:</span>
                            <span class="block text-gray-600">${order.customer_name || 'N/A'}</span>
                        </div>
                        <div class="mb-4">
                            <span class="block text-gray-700 text-sm font-bold mb-1">Total Amount:</span>
                            <span class="block text-gray-600">₱${parseFloat(order.total).toFixed(2)}</span>
                        </div>
                        <div class="mb-4">
                            <span class="block text-gray-700 text-sm font-bold mb-1">Status:</span>
                            <span class="block text-gray-600">${order.status}</span>
                        </div>
                        <div class="mb-4">
                            <span class="block text-gray-700 text-sm font-bold mb-1">Order Date:</span>
                            <span class="block text-gray-600">${new Date(order.created_at).toLocaleDateString('en-US', { year: 'numeric', month: 'long', day: 'numeric' })}</span>
                        </div>
                    </div>
                `;

                        // If there are related penalties
                        if (order.penalties && order.penalties.length > 0) {
                            orderDetails += `
                        <div class="mt-6 mb-4">
                            <span class="block text-gray-700 text-sm font-bold mb-2">Related Penalties:</span>
                            <div class="border rounded-lg overflow-hidden">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">ID</th>
                                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Amount</th>
                                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Reason</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                    `;

                            order.penalties.forEach(penalty => {
                                orderDetails += `
                            <tr>
                                <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-500">${penalty.id}</td>
                                <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-500">₱${parseFloat(penalty.amount).toFixed(2)}</td>
                                <td class="px-4 py-2 text-sm text-gray-500">${penalty.reason ? penalty.reason : 'No reason provided'}</td>
                            </tr>
                        `;
                            });

                            orderDetails += `
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    `;
                        }

                        Swal.fire({
                            title: `Order Details #${order.id}`,
                            html: orderDetails,
                            width: '600px',
                            confirmButtonText: 'Close',
                            confirmButtonColor: '#3085d6'
                        });
                    } else {
                        Swal.fire({
                            title: 'Error!',
                            text: data.message || 'Failed to load order details.',
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    Swal.fire({
                        title: 'Error!',
                        text: 'Something went wrong. Please try again.',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                });
        }
    </script>
</body>

</html>
