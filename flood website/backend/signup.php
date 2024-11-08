<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $firstName = $_POST['first_name'];
    $lastName = $_POST['last_name'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    if (!empty($firstName) && !empty($lastName) && !empty($email) && !empty($password)) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $conn->prepare("INSERT INTO users (first_name, last_name, email, password) VALUES (:first_name, :last_name, :email, :password)");
        $stmt->bindParam(':first_name', $firstName);
        $stmt->bindParam(':last_name', $lastName);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $hashedPassword);

        try {
            $stmt->execute();
            echo "User registered successfully!";
        } catch (PDOException $e) {
            if ($e->getCode() == '23505') {
                echo "This email is already registered!";
            } else {
                echo "Error: " . $e->getMessage();
            }
        }
    } else {
        echo "Please fill out all fields!";
    }
}
?>
