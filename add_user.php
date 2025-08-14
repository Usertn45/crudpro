<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['save'])) {
    $username = $_POST['username'];
    $age = $_POST['age'];
    $dob = $_POST['dob'];
    $gender = $_POST['gender'];
    $blood_group = $_POST['blood_group'];

    $stmt = $conn->prepare("INSERT INTO users (username, age, dob, gender, blood_group) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sisss", $username, $age, $dob, $gender, $blood_group);

    if ($stmt->execute()) {
        echo "User saved successfully!";
    } else {
        echo "Error: " . $conn->error;
    }
    $stmt->close();
}
?>

<form method="POST" action="">
  Username: <input type="text" name="username" required><br>
  Age: <input type="number" name="age" required><br>
  Date of Birth: <input type="date" name="dob" required><br>
  Gender:
  <select name="gender" required>
    <option value="">Select</option>
    <option value="Male">Male</option>
    <option value="Female">Female</option>
    <option value="Other">Other</option>
  </select><br>
  Blood Group: <input type="text" name="blood_group"><br>
  <button type="submit" name="save">Save</button>
</form>
