<?php

require_once 'login/users.php';
require_once 'login/login.php';



while (true) {
    echo "1. Sign in\n";
    echo "2. Sign up\n";
    echo "3. Exit\n";
    $choice = readline("Enter your choice: ");
    switch ($choice) {
        case 1:
            $user = Login::SignIn();
            if ($user) {
                echo 'Success!';
            }
            break;
        case 2:
            Login::SignUp();
            break;
        case 3:
            exit;
        default:
            echo "Invalid choice.\n";
    }
}
