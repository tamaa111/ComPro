<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['action']) && $_POST['action'] == 'create') {
        // Create User
        $username = $_POST['username'];
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $email = $_POST['email'];

        $sql = "INSERT INTO users (username, password, email) VALUES (?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$username, $password, $email]);

        echo json_encode(["status" => "success", "message" => "User created successfully"]);
    }

    if (isset($_POST['action']) && $_POST['action'] == 'delete') {
        // Delete User
        $id = $_POST['id'];

        $sql = "DELETE FROM users WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$id]);

        echo json_encode(["status" => "success", "message" => "User deleted successfully"]);
    }

    if (isset($_POST['action']) && $_POST['action'] == 'edit') {
        // Edit User
        $id = $_POST['id'];
        $username = $_POST['username'];
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $email = $_POST['email'];

        $sql = "UPDATE users SET username = ?, password = ?, email = ? WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$username, $password, $email, $id]);

        echo json_encode(["status" => "success", "message" => "User updated successfully"]);
    }
} elseif ($_SERVER['REQUEST_METHOD'] == 'GET') {
    // Read Users
    $sql = "SELECT * FROM users";
    $stmt = $pdo->query($sql);
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($users);
}
?>
