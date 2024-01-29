<?php


require_once 'users/users.php';
require_once 'login/login.php';

class Account
{

    public static function showBalance(User $user): void
    {
        echo "Your balance is: " . $user->getBalance() . "\n";
    }

    public static function deposit(User $user): void
    {
        $amount = readline("Enter the amount you want to deposit: ");
        $user->setBalance($user->getBalance() + $amount);
        echo "Your balance is: " . $user->getBalance() . "\n";
        User::update($user);
    }

    public static function withdraw(User $user): void
    {
        $amount = readline("Enter the amount you want to withdraw: ");
        if ($amount > $user->getBalance()) {
            echo "You don't have enough money.\n";
            return;
        }
        $user->setBalance($user->getBalance() - $amount);
        echo "Your balance is: " . $user->getBalance() . "\n";
        User::update($user);
    }

    public static function transfer(User $user): void
    {
        $amount = readline("Enter the amount you want to transfer: ");
        if ($amount > $user->getBalance()) {
            echo "You don't have enough money.\n";
            return;
        }
        $username = readline("Enter the username you want to transfer to: ");
        $userToTransfer = User::getByUsername($username);
        $userToTransfer = new User($userToTransfer['username'], $userToTransfer['password'], $userToTransfer['is_locked'], $userToTransfer['balance']);
        
        if (!$userToTransfer) {
            echo "User not found.\n";
            return;
        }

        $user->setBalance($user->getBalance() - $amount);
        $userToTransfer->setBalance($userToTransfer->getBalance() + $amount);
        User::update($user);
        User::update($userToTransfer);
    }
}
