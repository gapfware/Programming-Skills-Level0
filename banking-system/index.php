<?php

require_once 'users/users.php';
require_once 'login/login.php';
require_once 'users/account.php';

echo "Welcome to the bank.\n";
while (true) {
    echo "--------------------------------\n";
    echo "1. Sign in\n";
    echo "2. Sign up\n";
    echo "3. Exit\n";
    echo "--------------------------------\n";

    $choice = readline("Enter your choice: ");
    switch ($choice) {
        case 1:
            $user = Login::SignIn();
            if ($user) {
                while (true) {
                    echo "--------------------------------\n";
                    echo "1. Show balance\n";
                    echo "2. Deposit\n";
                    echo "3. Withdraw\n";
                    echo "4. Transfer\n";
                    echo "5. Sign out\n";
                    echo "--------------------------------\n";
                    $choice = readline("Enter your choice: ");
                    system('clear');
                    
                    switch ($choice) {
                        case 1:
                            Account::showBalance($user);
                            break;
                        case 2:
                            Account::deposit($user);
                            break;
                        case 3:
                            Account::withdraw($user);
                            break;
                        case 4:
                            Account::transfer($user);
                            break;
                        case 5:
                            exit;
                        default:
                            echo "Invalid choice.\n";
                    }
                }
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
