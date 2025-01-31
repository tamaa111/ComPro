<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD User</title>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.9.1" defer></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.6.0/dist/sweetalert2.all.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.16/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/4.2.0/remixicon.min.css" rel="stylesheet">
    <style>
        .loader {
            border-top-color: #3498db;
            -webkit-animation: spinner 1.5s linear infinite;
            animation: spinner 1.5s linear infinite;
        }

        @-webkit-keyframes spinner {
            0% {
                -webkit-transform: rotate(0deg);
            }

            100% {
                -webkit-transform: rotate(360deg);
            }
        }

        <blade keyframes|%20spinner%20%7B%0D>0% {
            transform: rotate(0deg);
        }

        100% {
            transform: rotate(360deg);
        }
    </style>
</head>

<body>
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4">User Management</h1>

        <!-- Button to trigger Create User Modal -->
        <button id="show-modal" class="bg-blue-500 text-white p-2 mb-4">Create User</button>

        <!-- Create User Modal -->
        <div id="create-user-modal"
            class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden">
            <div class="bg-white p-6 rounded-lg w-96">
                <h2 class="text-xl mb-4">Create New User</h2>
                <input id="username" class="border p-2 mb-2 w-full" type="text" placeholder="Username" required>
                <input id="password" class="border p-2 mb-2 w-full" type="password" placeholder="Password" required>
                <input id="email" class="border p-2 mb-2 w-full" type="email" placeholder="Email" required>
                <div class="flex justify-between mt-4">
                    <button id="create-user" class="bg-blue-500 text-white p-2">Create</button>
                    <button id="close-modal" class="bg-gray-500 text-white p-2">Cancel</button>
                </div>
            </div>
        </div>

        <!-- Loading Animation -->
        <div id="loading" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden">
            <div class="bg-white p-6 rounded-lg">
                <div class="loader ease-linear rounded-full border-4 border-t-4 border-gray-200 h-12 w-12 mb-4"></div>
                <p class="text-center">Loading</p>
            </div>
        </div>

        <!-- User List -->
        <table id="user-table" class="table-auto w-full border mt-4">
            <thead>
                <tr>
                    <th class="border p-2">ID</th>
                    <th class="border p-2">Username</th>
                    <th class="border p-2">Email</th>
                    <th class="border p-2">Actions</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
        <div id="pagination" class="mt-4 flex justify-center"> </div>
    </div>

   
    <script>
        // Show loading animation and hide user table
        function showLoading() {
            $('#loading').removeClass('hidden');
            $('#user-table').addClass('hidden'); // Hide the user table
        }

        // Hide loading animation and show user table
        function hideLoading() {
            $('#loading').addClass('hidden');
            $('#user-table').removeClass('hidden'); // Show the user table
        }

        // Fetch and display users
        function fetchUsers(page = 1) {
            showLoading(); // Show loading animation

            // Simulate a delay before fetching data
            setTimeout(function () {
                $.ajax({
                    url: 'user_crud.php',
                    method: 'GET',
                    data: {
                        page: page
                    },
                    success: function (data) {
                        let result = JSON.parse(data);
                        let users = result.users;
                        let rows = '';
                        users.forEach(function (user) {
                            rows += `
                        <tr>
                            <td class="border p-2">${user.id}</td>
                            <td class="border p-2" id="username-${user.id}">${user.username}</td>
                            <td class="border p-2" id="email-${user.id}">${user.email}</td>
                            <td class="border p-2">
                                <button class="edit-btn text-yellow-500 p-1" data-id="${user.id}">
                                    <i class="ri-edit-2-line"></i>
                                </button>
                                <button class="save-btn text-green-500 p-1 hidden" data-id="${user.id}">
                                    <i class="ri-save-3-line"></i>
                                </button>
                                <button class="delete-btn bg-red-500 text-white p-1" data-id="${user.id}">
                                    <i class="ri-delete-bin-5-line"></i>
                                </button>
                            </td>
                        </tr>
                    `;
                        });

                        // Render rows
                        $('#user-table tbody').html(rows);

                        // Render pagination buttons
                        let pagination = '';
                        for (let i = 1; i <= result.totalPages; i++) {
                            pagination += `
                        <button class="pagination-btn ${result.currentPage === i ? 'bg-blue-500 text-white' : 'bg-gray-300'} px-2 py-1 m-1"
                            data-page="${i}">${i}</button>
                    `;
                        }
                        $('#pagination').html(pagination);

                        hideLoading(); // Hide loading animation after data is loaded
                    },
                    error: function () {
                        hideLoading(); // Hide loading animation and show error message
                        Swal.fire({
                            title: 'Error',
                            text: 'Failed to fetch data. Please try again.',
                            icon: 'error',
                        });
                    }
                });
            }, 300); // delay
        }

        // Handle pagination button click
        $(document).on('click', '.pagination-btn', function () {
            let page = $(this).data('page');
            fetchUsers(page);
        });

        // Initial fetch of users with page 1
        $(document).ready(function () {
            fetchUsers(1);
        });

        // Create user
        $('#create-user').click(function () {
            let username = $('#username').val();
            let password = $('#password').val();
            let email = $('#email').val();

            // Validation: check if fields are empty or email format is incorrect
            if (!username || !password || !email || !email.includes('@')) {
                Swal.fire({
                    title: 'Validation Error',
                    text: 'Please fill in all fields correctly.',
                    icon: 'error',
                });
                return;
            }

            $.ajax({
                url: 'user_crud.php',
                method: 'POST',
                data: {
                    action: 'create',
                    username: username,
                    password: password,
                    email: email
                },
                success: function (response) {
                    let result = JSON.parse(response);
                    Swal.fire({
                        title: result.message,
                        icon: 'success',
                        background: '#4CAF50', // Green color for success
                        color: '#fff',
                    });
                    $('#create-user-modal').addClass('hidden');
                    $('#username').val('');
                    $('#password').val('');
                    $('#email').val('');
                    fetchUsers(); // Refresh user list
                }
            });
        });

        // Edit user
        $(document).on('click', '.edit-btn', function () {
            let id = $(this).data('id');
            let username = $(`#username-${id}`).text();
            let email = $(`#email-${id}`).text();

            // Replace text with input fields for editing
            $(`#username-${id}`).html(`<input type="text" value="${username}" class="border p-2">`);
            $(`#email-${id}`).html(`<input type="email" value="${email}" class="border p-2">`);

            // Show Save button and hide Edit button
            $(`.edit-btn[data-id="${id}"]`).addClass('hidden');
            $(`.save-btn[data-id="${id}"]`).removeClass('hidden');
        });

        // Save changes after inline editing
        $(document).on('click', '.save-btn', function () {
            let id = $(this).data('id');
            let newUsername = $(`#username-${id} input`).val();
            let newEmail = $(`#email-${id} input`).val();

            // Validate input
            if (!newUsername || !newEmail || !newEmail.includes('@')) {
                Swal.fire({
                    title: 'Validation Error',
                    text: 'Please fill in all fields correctly.',
                    icon: 'error',
                });
                return;
            }

            // Save changes to server
            $.ajax({
                url: 'user_crud.php',
                method: 'POST',
                data: {
                    action: 'edit',
                    id: id,
                    username: newUsername,
                    email: newEmail
                },
                success: function (response) {
                    // Replace input fields with updated text
                    $(`#username-${id}`).text(newUsername);
                    $(`#email-${id}`).text(newEmail);

                    // Show Edit button and hide Save button
                    $(`.edit-btn[data-id="${id}"]`).removeClass('hidden');
                    $(`.save-btn[data-id="${id}"]`).addClass('hidden');

                    // Show success notification
                    Swal.fire({
                        title: 'Update',
                        text: 'User  data has been updated successfully.',
                        icon: 'info',
                    });
                },
                error: function () {
                    // Show error notification
                    Swal.fire({
                        title: 'Error',
                        text: 'Failed to update user data. Please try again.',
                        icon: 'error',
                    });
                }
            });
        });

        // Delete user
        $(document).on('click', '.delete-btn', function () {
            let id = $(this).data('id');

            Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#3085d6",
                confirmButtonText: "Yes, delete it!"
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: 'user_crud.php',
                        method: 'POST',
                        data: {
                            action: 'delete',
                            id: id
                        },
                        success: function (response) {
                            let result = JSON.parse(response);
                            Swal.fire({
                                title: result.message,
                                icon: 'success'
                            });
                            fetchUsers();
                        },
                        error: function () {
                            Swal.fire({
                                title: 'Error',
                                text: 'Failed to delete user.',
                                icon: 'error'
                            });
                        }
                    });
                }
            });
        });
    </script>
</body>

</html>