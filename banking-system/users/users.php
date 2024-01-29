<?php

$filepath = 'users/users.php';

class User
{
    private $username;
    private $password;
    private $isLocked;
    private $balance;


    public function __construct(string $username, string $password, bool $isLocked = false, int $balance = 2000)
    {
        $this->username = $username;
        $this->password = $password;
        $this->isLocked = $isLocked;
        $this->balance = $balance;
    }

    public static function getFilePath(): string
    {
        return 'users/users.json';
    }

    /**1
     * Get all users from the JSON file.
     */
    public static function getAll(): array
    {
        $filename = User::getFilePath();
        $users = file_get_contents($filename);
        $users = json_decode($users, true);
        return $users;
    }

    /**
     * Save a user to the JSON file.
     */
    public static function save(User $user): void
    {
        $filename = User::getFilePath();
        $users = self::getAll();
        $users[] = [
            'username' => $user->getUsername(),
            'password' => $user->getPassword(),
            'balance' => $user->getBalance(),
            'is_locked' => $user->isLocked()

        ];
        $users = json_encode($users);
        file_put_contents($filename, $users);
    }

    public static function update(User $user): void
    {
        $filename = User::getFilePath();
        $users = self::getAll();
        foreach ($users as $key => $value) {
            if ($value['username'] === $user->getUsername()) {
                $users[$key]['balance'] = $user->getBalance();
            }
        }
        $users = json_encode($users);
        file_put_contents($filename, $users);
    }

    /**
     * Get the username.
     */
    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * Get the password.
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * Check if the user is locked.
     */
    public function isLocked(): bool
    {
        return $this->isLocked;
    }

    /**
     * Get the balance.
     */
    public function getBalance(): int
    {
        return $this->balance;
    }

    /**
     * Set the balance.
     */
    public function setBalance(int $balance): void
    {
        $this->balance = $balance;
    }

    /**
     * Get a user by username.
     */
    public static function getByUsername(string $username): ?array
    {
        $users = self::getAll();
        foreach ($users as $user) {
            if ($user['username'] === $username) {
                return $user;
            }
        }
        return null;
    }

    /**
     * Create a new user.
     */
    public static function create(): ?User
    {
        system('clear');
        echo "Please enter your information.\n";
        echo '--------------------------------' . PHP_EOL;
        $username = readline("Please enter a username: ");
        $password = readline("Please enter a password: ");
        $passwordVerification = readline("Please enter your password again: ");
        echo '--------------------------------' . PHP_EOL;

        if ($password !== $passwordVerification) {
            echo "Passwords do not match. Please try again.\n";
            return null;
        }

        if (self::getByUsername($username)) {
            echo "Username already exists. Please try again.\n";
            return null;
        }

        $user = new User($username, $password);
        self::save($user);
        echo "User created successfully.\n";
        return $user;
    }
}
