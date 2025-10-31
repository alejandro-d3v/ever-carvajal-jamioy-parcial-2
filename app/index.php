<?php

$host = getenv('DB_HOST') ?: 'db';
$dbname = getenv('MYSQL_DATABASE') ?: 'myapp';
$user = 'root';
$pass = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $pdo->query('SELECT id, name, email FROM users');
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>PHP MySQL Docker App</title>
        <style>
            body {
                font-family: Arial, sans-serif;
                max-width: 900px;
                margin: 50px auto;
                padding: 20px;
            }
            h1 {
                color: #333;
            }
            table {
                width: 100%;
                border-collapse: collapse;
                margin-top: 20px;
            }
            th, td {
                border: 1px solid #ddd;
                padding: 12px;
                text-align: left;
            }
            th {
                background-color: #4CAF50;
                color: white;
            }
            tr:nth-child(even) {
                background-color: #f2f2f2;
            }
            .form-container {
                margin-top: 30px;
                padding: 20px;
                background-color: #f9f9f9;
                border-radius: 5px;
            }
            input[type="text"], input[type="email"] {
                width: 100%;
                padding: 10px;
                margin: 5px 0;
                box-sizing: border-box;
            }
            button {
                background-color: #4CAF50;
                color: white;
                padding: 10px 20px;
                border: none;
                cursor: pointer;
                margin-top: 10px;
                border-radius: 3px;
            }
            button:hover {
                background-color: #45a049;
            }
            .btn-edit {
                background-color: #2196F3;
                padding: 5px 10px;
                margin-right: 5px;
            }
            .btn-edit:hover {
                background-color: #0b7dda;
            }
            .btn-delete {
                background-color: #f44336;
                padding: 5px 10px;
            }
            .btn-delete:hover {
                background-color: #da190b;
            }
            .btn-cancel {
                background-color: #9e9e9e;
                margin-left: 10px;
            }
            .btn-cancel:hover {
                background-color: #757575;
            }
            .message {
                padding: 10px;
                margin: 10px 0;
                border-radius: 5px;
            }
            .success {
                background-color: #d4edda;
                color: #155724;
            }
            .error {
                background-color: #f8d7da;
                color: #721c24;
            }
            .actions {
                white-space: nowrap;
            }
        </style>
    </head>
    <body>
        <h1>Welcome to the PHP MySQL Docker App!</h1>
        <p>Connected successfully to database: <strong><?php echo htmlspecialchars($dbname); ?></strong></p>

        <h2>Users List</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user): ?>
                <tr>
                    <td><?php echo htmlspecialchars($user['id']); ?></td>
                    <td><?php echo htmlspecialchars($user['name']); ?></td>
                    <td><?php echo htmlspecialchars($user['email']); ?></td>
                    <td class="actions">
                        <button class="btn-edit" onclick="editUser(<?php echo $user['id']; ?>, '<?php echo htmlspecialchars($user['name'], ENT_QUOTES); ?>', '<?php echo htmlspecialchars($user['email'], ENT_QUOTES); ?>')">Edit</button>
                        <button class="btn-delete" onclick="deleteUser(<?php echo $user['id']; ?>)">Delete</button>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <div class="form-container">
            <h2 id="formTitle">Add New User</h2>
            <form id="userForm">
                <input type="hidden" id="userId" name="userId">

                <label for="name">Name:</label>
                <input type="text" id="name" name="name" required>

                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>

                <button type="submit" id="submitBtn">Add User</button>
                <button type="button" class="btn-cancel" id="cancelBtn" style="display:none;" onclick="cancelEdit()">Cancel</button>
            </form>
            <div id="message"></div>
        </div>

        <script>
            let editMode = false;
            let currentUserId = null;

            document.getElementById('userForm').addEventListener('submit', async function(e) {
                e.preventDefault();

                const name = document.getElementById('name').value;
                const email = document.getElementById('email').value;
                const messageDiv = document.getElementById('message');

                try {
                    let response;
                    if (editMode) {
                        response = await fetch('/users.php?id=' + currentUserId, {
                            method: 'PUT',
                            headers: {
                                'Content-Type': 'application/json',
                            },
                            body: JSON.stringify({ name, email })
                        });
                    } else {
                        response = await fetch('/users.php', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                            },
                            body: JSON.stringify({ name, email })
                        });
                    }

                    const data = await response.json();

                    if (response.ok) {
                        messageDiv.className = 'message success';
                        messageDiv.textContent = editMode ? 'User updated successfully!' : 'User added successfully!';
                        setTimeout(() => location.reload(), 1000);
                    } else {
                        messageDiv.className = 'message error';
                        messageDiv.textContent = 'Error: ' + (data.error || 'Unknown error');
                    }
                } catch (error) {
                    messageDiv.className = 'message error';
                    messageDiv.textContent = 'Error: ' + error.message;
                }
            });

            function editUser(id, name, email) {
                editMode = true;
                currentUserId = id;

                document.getElementById('formTitle').textContent = 'Edit User';
                document.getElementById('name').value = name;
                document.getElementById('email').value = email;
                document.getElementById('submitBtn').textContent = 'Update User';
                document.getElementById('cancelBtn').style.display = 'inline-block';
                document.getElementById('message').textContent = '';

                document.querySelector('.form-container').scrollIntoView({ behavior: 'smooth' });
            }

            function cancelEdit() {
                editMode = false;
                currentUserId = null;

                document.getElementById('formTitle').textContent = 'Add New User';
                document.getElementById('name').value = '';
                document.getElementById('email').value = '';
                document.getElementById('submitBtn').textContent = 'Add User';
                document.getElementById('cancelBtn').style.display = 'none';
                document.getElementById('message').textContent = '';
            }

            async function deleteUser(id) {
                if (!confirm('Are you sure you want to delete this user?')) {
                    return;
                }

                const messageDiv = document.getElementById('message');

                try {
                    const response = await fetch('/users.php?id=' + id, {
                        method: 'DELETE'
                    });

                    const data = await response.json();

                    if (response.ok) {
                        messageDiv.className = 'message success';
                        messageDiv.textContent = 'User deleted successfully!';
                        setTimeout(() => location.reload(), 1000);
                    } else {
                        messageDiv.className = 'message error';
                        messageDiv.textContent = 'Error: ' + (data.error || 'Unknown error');
                    }
                } catch (error) {
                    messageDiv.className = 'message error';
                    messageDiv.textContent = 'Error: ' + error.message;
                }
            }
        </script>
    </body>
    </html>
    <?php
} catch (PDOException $e) {
    echo "<p>Connection failed: " . $e->getMessage() . "</p>";
}

?>
