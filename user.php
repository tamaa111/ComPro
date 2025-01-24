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
    </div>

    <script>
        // Show Create User Modal
        $('#show-modal').click(function () {
            $('#create-user-modal').removeClass('hidden');
        });

        // Close Create User Modal
        $('#close-modal').click(function () {
            $('#create-user-modal').addClass('hidden');
        });

        // Fetch and display users
        function fetchUsers() {
            $.ajax({
                url: 'user_crud.php',
                method: 'GET',
                success: function (data) {
                    let users = JSON.parse(data);
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
                    $('#user-table tbody').html(rows);
                }
            });
        }

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
                        text: 'User data has been updated successfully.',
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
                        icon: 'error', // Red color for error
                        background: '#F44336', // Red background
                        color: '#fff',
                    });
                    fetchUsers(); // Refresh user list
                }
            });
        });

        // Initial fetch of users
        $(document).ready(function () {
            fetchUsers();
        });
    </script>
</body>

</html>