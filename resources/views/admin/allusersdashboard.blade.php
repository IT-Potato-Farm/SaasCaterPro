<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Management Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.5/flowbite.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body class="bg-gray-50">
    <div class="flex h-screen">

        {{-- SIDENAV --}}
        <x-dashboard.side-nav />
        {{-- END SIDENAV --}}

        <div class="flex-1 flex flex-col overflow-hidden">
            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-50 p-6">
                <div class="container mx-auto">
                    <!-- Page Header -->
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6">
                        <div>
                            <h1 class="text-2xl font-bold text-gray-800">User Management</h1>
                            <p class="text-gray-600 mt-1">Manage all system users </p>
                        </div>
                        <div class="mt-4 md:mt-0">
                            <a href="#" id="addNewUserBtn"
                                class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-md transition-colors">
                                <i class="fas fa-plus mr-2"></i> Add New User
                            </a>
                        </div>
                    </div>

                    <!-- User Table -->
                    <div class="bg-white rounded-lg shadow overflow-hidden">
                        <div
                            class="px-6 py-4 border-b border-gray-200 flex flex-col md:flex-row md:items-center md:justify-between">
                            <div class="mb-4 md:mb-0">
                                <div class="relative">
                                    <input type="text" id="userSearch" placeholder="Search users..."
                                        class="pl-10 pr-4 py-2 rounded-md border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                    <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                                </div>
                            </div>

                        </div>

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
                                            User
                                        </th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Mobile
                                        </th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Email
                                        </th>
                                        {{-- <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Role
                                        </th> --}}
                                        {{-- <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Status
                                        </th> --}}
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Registered On
                                        </th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Actions
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200" id="userTableBody">
                                    @forelse ($users as $user)
                                        <tr class="hover:bg-gray-50 transition-colors">
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                {{ $user->id }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="flex items-center">
                                                    <div
                                                        class="flex-shrink-0 h-10 w-10 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 font-semibold">
                                                        {{ strtoupper(substr($user->first_name, 0, 1)) }}
                                                    </div>
                                                    <div class="ml-4">
                                                        <div class="text-sm font-medium text-gray-900">
                                                            {{ $user->first_name }} {{ $user->last_name }}</div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                {{ $user->mobile }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                {{ $user->email }}
                                            </td>
                                            {{-- <td class="px-6 py-4 whitespace-nowrap">
                                                <label class="relative inline-flex items-center cursor-pointer">
                                                    <input type="checkbox" value=""
                                                        class="sr-only peer role-toggle"
                                                        data-user-id="{{ $user->id }}"
                                                        {{ $user->role === 'admin' ? 'checked' : '' }}>
                                                    <div
                                                        class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600">
                                                    </div>
                                                    <span class="ml-3 text-sm font-medium text-gray-900">
                                                        {{ $user->role === 'admin' ? 'Admin' : 'Customer' }}
                                                    </span>
                                                </label>
                                            </td> --}}
                                            {{-- <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                                    {{ $user->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                                    {{ ucfirst($user->status) }}
                                                </span>
                                            </td> --}}
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ $user->created_at->format('M d, Y') }}
                                                <div class="text-xs text-gray-400">
                                                    {{ $user->created_at->diffForHumans() }}
                                                </div>
                                            </td>
                                            {{-- ACTIONS --}}
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                <div class="flex space-x-2">
                                                    <!-- Edit Button -->
                                                    <button type="button" data-user-id="{{ $user->id }}"
                                                        class="edit-user-btn inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded-full shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-200">
                                                        <svg class="w-4 h-4 mr-1 -ml-1" fill="none"
                                                            stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                        </svg>
                                                        Edit
                                                    </button>

                                                    <!-- View Button -->
                                                    <button type="button" data-user-id="{{ $user->id }}"
                                                        class="view-user-btn inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded-full shadow-sm text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition duration-200">
                                                        <svg class="w-4 h-4 mr-1 -ml-1" fill="none"
                                                            stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                        </svg>
                                                        View
                                                    </button>

                                                    <!-- Delete Button -->
                                                    <button type="button" data-user-id="{{ $user->id }}"
                                                        class="delete-user-btn inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded-full shadow-sm text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition duration-200">
                                                        <svg class="w-4 h-4 mr-1 -ml-1" fill="none"
                                                            stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5-4h4M9 7v12m6-12v12" />
                                                        </svg>
                                                        Delete
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7"
                                                class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-500">
                                                No users found.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        @if ($users->hasPages())
                            <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
                                <div class="flex items-center justify-between">
                                    <div class="text-sm text-gray-700">
                                        Showing <span class="font-medium">{{ $users->firstItem() }}</span> to
                                        <span class="font-medium">{{ $users->lastItem() }}</span> of
                                        <span class="font-medium">{{ $users->total() }}</span> results
                                    </div>
                                    <div>
                                        {{ $users->links() }}
                                    </div>
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
            userCreate: '{{ route('api.users.store') }}',
            userShow: '{{ route('api.users.show', ':id') }}',
            userUpdate: '{{ route('api.users.update', ':id') }}',
            userDestroy: '{{ route('api.users.destroy', ':id') }}',
            userUpdateRole: '{{ route('api.users.role', ':id') }}',
        };
    </script>
    <script>
        // sweetalert add edit view delete
        document.addEventListener('DOMContentLoaded', function() {
            // ADD
            document.getElementById('addNewUserBtn').addEventListener('click', function() {
                Swal.fire({
                    title: 'Add New User',
                    html: `
                        <div class="text-left w-full">
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700 mb-1">First Name</label>
                                <input type="text" id="firstName" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" placeholder="First Name">
                            </div>
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Last Name</label>
                                <input type="text" id="lastName" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" placeholder="Last Name">
                            </div>
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                                <input type="email" id="email" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" placeholder="Email">
                            </div>
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Mobile</label>
                                <input type="text" id="mobile" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" placeholder="Mobile">
                            </div>
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Role</label>
                                <select id="role" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                                    <option value="admin">Admin</option>
                                    <option value="customer">Customer</option>
                                </select>
                            </div>
                        </div>
                    `,
                    confirmButtonText: 'Add User',
                    showCancelButton: true,
                    cancelButtonText: 'Cancel',
                    preConfirm: () => {
                        const firstName = document.getElementById('firstName').value;
                        const lastName = document.getElementById('lastName').value;
                        const email = document.getElementById('email').value;
                        const mobile = document.getElementById('mobile').value;
                        const role = document.getElementById('role').value;

                        if (!firstName || !lastName || !email || !mobile || !role) {
                            Swal.showValidationMessage('Please fill out all fields');
                            return false;
                        }
                        const emailRegex = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
                        if (!emailRegex.test(email)) {
                            Swal.showValidationMessage('Please enter a valid email address');
                            return false;
                        }

                        return {
                            firstName,
                            lastName,
                            email,
                            mobile,
                            role
                        };
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        const {
                            firstName,
                            lastName,
                            email,
                            mobile,
                            role
                        } = result.value;
                        const createUrl = routes.userCreate;
                        // API request to add the user
                        fetch(createUrl, {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': document.querySelector(
                                        'meta[name="csrf-token"]').getAttribute('content'),

                                    'Authorization': 'Bearer ' + localStorage.getItem(
                                        'token'), // Replace with token if required
                                },
                                body: JSON.stringify({
                                    first_name: firstName,
                                    last_name: lastName,
                                    email: email,
                                    mobile: mobile,
                                    role: role
                                })
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    Swal.fire('Success!', 'User added successfully.',
                                        'success');

                                } else {
                                    Swal.fire('Error!', data.message || 'Failed to add user.',
                                        'error');
                                }
                            })
                            .catch(error => {
                                console.error('Fetch Error:', error);
                                Swal.fire('Error!', 'An error occurred: ' + error.message,
                                    'error');
                            });
                    }
                });
            });
            // Edit user functionality
            document.querySelectorAll('.edit-user-btn').forEach(button => {
                button.addEventListener('click', function() {
                    const userId = this.getAttribute('data-user-id');
                    const fetchUrl = routes.userShow.replace(':id', userId);

                    // Fetch user data
                    fetch(fetchUrl)
                        .then(response => response.json())
                        .then(user => {
                            // Show edit form with SweetAlert
                            Swal.fire({
                                title: 'Edit User',
                                html: `
                            <form id="editUserForm" class="text-left">
                                <div class="mb-4">
                                    <label class="block text-gray-700 text-sm font-bold mb-2" for="first_name">
                                        First Name
                                    </label>
                                    <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                           id="first_name" type="text" value="${user.first_name}">
                                </div>
                                <div class="mb-4">
                                    <label class="block text-gray-700 text-sm font-bold mb-2" for="last_name">
                                        Last Name
                                    </label>
                                    <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                           id="last_name" type="text" value="${user.last_name}">
                                </div>
                                <div class="mb-4">
                                    <label class="block text-gray-700 text-sm font-bold mb-2" for="email">
                                        Email
                                    </label>
                                    <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                           id="email" type="email" value="${user.email}">
                                </div>
                                <div class="mb-4">
                                    <label class="block text-gray-700 text-sm font-bold mb-2" for="mobile">
                                        Mobile
                                    </label>
                                    <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                           id="mobile" type="text" value="${user.mobile}">
                                </div>

                            </form>
                        `,
                                showCancelButton: true,
                                confirmButtonText: 'Save Changes',
                                confirmButtonColor: '#3085d6',
                                cancelButtonColor: '#d33',
                                focusConfirm: false,
                                preConfirm: () => {
                                    // Get form values
                                    const first_name = document.getElementById(
                                        'first_name').value;
                                    const last_name = document.getElementById(
                                        'last_name').value;
                                    const email = document.getElementById('email')
                                        .value;
                                    const mobile = document.getElementById('mobile')
                                        .value;


                                    // Validate form
                                    if (!first_name || !last_name || !email || !
                                        mobile) {
                                        Swal.showValidationMessage(
                                            'Please fill all required fields');
                                        return false;
                                    }

                                    // Return form data
                                    return {
                                        first_name,
                                        last_name,
                                        email,
                                        mobile
                                       
                                    };
                                }
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    // Send update request
                                    const updateUrl = routes.userUpdate.replace(':id',
                                        userId);
                                    fetch(updateUrl, {
                                            method: 'PUT',
                                            headers: {
                                                'Content-Type': 'application/json',
                                                'X-CSRF-TOKEN': document
                                                    .querySelector(
                                                        'meta[name="csrf-token"]')
                                                    .getAttribute('content')
                                            },
                                            body: JSON.stringify(result.value)
                                        })
                                        .then(response => response.json())
                                        .then(data => {
                                            if (data.success) {
                                                Swal.fire(
                                                    'Updated!',
                                                    'User has been updated successfully.',
                                                    'success'
                                                ).then(() => {
                                                    // Reload page to show updated data
                                                    window.location
                                                        .reload();
                                                });
                                            } else {
                                                Swal.fire(
                                                    'Error!',
                                                    data.message ||
                                                    'Failed to update user.',
                                                    'error'
                                                );
                                            }
                                        })
                                        .catch(error => {
                                            console.error('Error:', error);
                                            Swal.fire(
                                                'Error!',
                                                'An error occurred while updating the user.',
                                                'error'
                                            );
                                        });
                                }
                            });
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            Swal.fire(
                                'Error!',
                                'Failed to fetch user data.',
                                'error'
                            );
                        });
                });
            });

            // View user functionality
            document.querySelectorAll('.view-user-btn').forEach(button => {
                button.addEventListener('click', function() {
                    const userId = this.getAttribute('data-user-id');
                    const viewUrl = routes.userShow.replace(':id', userId);
                    // Fetch user data
                    fetch(viewUrl)
                        .then(response => response.json())
                        .then(user => {
                            // Show user details with SweetAlert
                            Swal.fire({
                                title: 'User Details',
                                html: `
                            <div class="text-left">
                                <div class="mb-3">
                                    <p class="text-sm font-medium text-gray-500">Name</p>
                                    <p class="text-base font-semibold">${user.first_name} ${user.last_name}</p>
                                </div>
                                <div class="mb-3">
                                    <p class="text-sm font-medium text-gray-500">Email</p>
                                    <p class="text-base">${user.email}</p>
                                </div>
                                <div class="mb-3">
                                    <p class="text-sm font-medium text-gray-500">Mobile</p>
                                    <p class="text-base">${user.mobile}</p>
                                </div>
                                <div class="mb-3">
                                    <p class="text-sm font-medium text-gray-500">Role</p>
                                    <p class="text-base capitalize">${user.role}</p>
                                </div>
                                <div class="mb-3">
                                    <p class="text-sm font-medium text-gray-500">Registered On</p>
                                    <p class="text-base">${new Date(user.created_at).toLocaleDateString()}</p>
                                </div>
                            </div>
                        `,
                                confirmButtonText: 'Close',
                                confirmButtonColor: '#3085d6'
                            });
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            Swal.fire(
                                'Error!',
                                'Failed to fetch user data.',
                                'error'
                            );
                        });
                });
            });

            // Delete user confirmation
            document.querySelectorAll('.delete-user-btn').forEach(button => {
                button.addEventListener('click', function() {
                    const form = this.closest('form');

                    Swal.fire({
                        title: 'Are you sure?',
                        text: "You won't be able to revert this!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, delete it!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });
                });
            });

            // Delete user functionality
            document.querySelectorAll('.delete-user-btn').forEach(button => {
                button.addEventListener('click', function() {
                    const userId = this.getAttribute('data-user-id');
                    const deleteUrl = routes.userDestroy.replace(':id', userId);
                    // Show confirmation dialog
                    Swal.fire({
                        title: 'Are you sure?',
                        text: "You won't be able to revert this!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Yes, delete it!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Send delete request
                            fetch(deleteUrl, {
                                    method: 'DELETE',
                                    headers: {
                                        'Content-Type': 'application/json',
                                        'X-CSRF-TOKEN': document.querySelector(
                                            'meta[name="csrf-token"]').getAttribute(
                                            'content')
                                    }
                                })
                                .then(response => response.json())
                                .then(data => {
                                    if (data.success) {
                                        Swal.fire(
                                            'Deleted!',
                                            'User has been deleted.',
                                            'success'
                                        ).then(() => {
                                            // Remove the row from the table or reload the page
                                            const row = button.closest('tr');
                                            if (row) {
                                                row.remove();
                                            } else {
                                                window.location.reload();
                                            }
                                        });
                                    } else {
                                        Swal.fire(
                                            'Error!',
                                            data.message ||
                                            'Failed to delete user.',
                                            'error'
                                        );
                                    }
                                })
                                .catch(error => {
                                    console.error('Error:', error);
                                    Swal.fire(
                                        'Error!',
                                        'An error occurred while deleting the user.',
                                        'error'
                                    );
                                });
                        }
                    });
                });
            });
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Role toggle functionality
            document.querySelectorAll('.role-toggle').forEach(toggle => {
                toggle.addEventListener('change', function() {
                    const userId = this.dataset.userId;
                    const newRole = this.checked ? 'admin' : 'customer';
                    const updateRoleUrl = routes.userUpdateRole.replace(':id', userId);
                    fetch(updateRoleUrl, {
                            method: 'PUT',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({
                                role: newRole
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Role Updated',
                                    text: `User role changed to ${newRole}`,
                                    showConfirmButton: false,
                                    timer: 1500
                                });

                                // Update the role text next to the toggle
                                const roleText = this.closest('label').querySelector('span');
                                roleText.textContent = newRole === 'admin' ? 'Admin' :
                                    'Customer';
                            } else {
                                // Revert the toggle if update failed
                                this.checked = !this.checked;
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: data.message || 'Failed to update role',
                                });
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            this.checked = !this.checked;
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'Failed to update role',
                            });
                        });
                });
            });

            // User search functionality
            document.getElementById('userSearch').addEventListener('input', function(e) {
                const searchTerm = e.target.value.toLowerCase();
                const rows = document.querySelectorAll('#userTableBody tr');

                rows.forEach(row => {
                    const userName = row.querySelector('td:nth-child(2) .text-gray-900').textContent
                        .toLowerCase();
                    const userEmail = row.querySelector('td:nth-child(3)').textContent
                        .toLowerCase();

                    if (userName.includes(searchTerm) || userEmail.includes(searchTerm)) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                });
            });

            // Role filter
            document.getElementById('roleFilter').addEventListener('change', function(e) {
                const role = e.target.value;
                const rows = document.querySelectorAll('#userTableBody tr');

                rows.forEach(row => {
                    if (!role || row.querySelector('.role-toggle').checked === (role === 'admin')) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                });
            });

            // Status filter
            // document.getElementById('statusFilter').addEventListener('change', function(e) {
            //     const status = e.target.value;
            //     const rows = document.querySelectorAll('#userTableBody tr');

            //     rows.forEach(row => {
            //         const statusElement = row.querySelector('td:nth-child(5) span');
            //         if (statusElement) {
            //             const userStatus = statusElement.textContent.toLowerCase();
            //             if (!status || userStatus === status) {
            //                 row.style.display = '';
            //             } else {
            //                 row.style.display = 'none';
            //             }
            //         }
            //     });
            // });


        });
    </script>
</body>

</html>
