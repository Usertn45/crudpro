<?php
include 'db.php'; // DB connection

// Fetch all users from the database
$result = $conn->query("SELECT id, username, age, dob, gender, blood_group FROM users ORDER BY id ASC");
?>
<!DOCTYPE html>
<html>
<head>
    <title>User Dashboard</title>
    <style>
        table {
            border-collapse: collapse;
            width: 80%;
            margin: 20px auto;
        }
        th, td {
            border: 1px solid #555;
            padding: 8px;
            text-align: center;
        }
        th {
            background: #f4f4f4;
        }
        a.button {
            display: inline-block;
            padding: 5px 10px;
            background: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 4px;
        }
        a.delete-btn {
            background: #dc3545;
        }
    </style>
</head>
<body>

<h2 style="text-align:center;">📋 User Management Dashboard</h2>

<table>
    <tr>
        <th>ID</th>
        <th>Username</th>
        <th>Age</th>
        <th>Date of Birth</th>
        <th>Gender</th>
        <th>Blood Group</th>
        <th>Actions</th>
    </tr>

    <?php 
    $i = 1; // Counter for sequential numbering
    while($row = $result->fetch_assoc()): 
    ?>
        <tr>
            <td><?= $i++; ?></td> <!-- Sequential numbering -->
            <td><?= htmlspecialchars($row['username']); ?></td>
            <td><?= $row['age']; ?></td>
            <td><?= $row['dob']; ?></td>
            <td><?= $row['gender']; ?></td>
            <td><?= $row['blood_group']; ?></td>
            <td>
                <!-- Ensure these files exist in the same folder -->
                <a class="button" href="e.php?username=<?= urlencode($row['username']); ?>">Edit</a>
                <a class="button delete-btn" href="d.php?username=<?= urlencode($row['username']); ?>" onclick="return confirm('Are you sure you want to delete this user?');">Delete</a>
            </td>
        </tr>
    <?php endwhile; ?>
</table>

<p style="text-align:center;">
    <a class="button" href="add_user.php">➕ Add New User</a>
</p>

</body>
</html>
