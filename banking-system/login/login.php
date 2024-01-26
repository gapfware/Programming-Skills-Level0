<?php

require_once 'login/users.php';


class Login
{

    /**
     * Lock a user.
     */
    private static function lockUser(string $username): void
    {
        $filename = "login/users.json";
        $users = User::getAll();
        foreach ($users as $key => $user) {
            if ($user['username'] === $username) {
                $users[$key]['is_locked'] = true;
            }
        }
        $users = json_encode($users);
        file_put_contents($filename, $users);
    }

    public static function SignIn(): User | bool
    {
        $attemps = 0;
        $username = readline("Please enter a username: ");
        $password = readline("Please enter a password: ");
        $user = User::getByUsername($username);

        while ($user['password'] !== $password) {
            $attemps++;
            if ($attemps === 3) {
                self::lockUser($username);
                echo "You have been locked out.";
                exit;
            }
            echo "Wrong password, try again.\n";
            $password = readline("Please enter a password: ");
        }

        if ($user['is_locked']) {
            echo "You have been locked out. Please contact the administrator.";
            return false;
        }

        echo "Welcome " . $username . "!\n";
        return new User($user['username'], $user['password'], $user['is_locked']);
    }

    public static function SignUp(){
        return User::create();
    }
}
