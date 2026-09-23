<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Factories\RepositoryFactory;

class AuthController extends Controller
{
    public function showLogin(): void
    {
        if (!empty($_SESSION['user_id'])) {
            $this->redirect('/dashboard');
        }

        $error = $_SESSION['flash_error'] ?? null;
        unset($_SESSION['flash_error']);

        $this->renderPlain('auth/login', ['error' => $error]);
    }

    public function login(): void
    {
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';

        $userRepository = RepositoryFactory::make('user');
        $user = $userRepository->findByEmail($email);

        if (!$user || !password_verify($password, $user->password)) {
            $_SESSION['flash_error'] = 'E-mail ou senha inválidos.';
            $this->redirect('/login');
            return;
        }

        $_SESSION['user_id'] = $user->id;
        $_SESSION['user_name'] = $user->name;

        $this->redirect('/dashboard');
    }

    public function showRegister(): void
    {
        if (!empty($_SESSION['user_id'])) {
            $this->redirect('/dashboard');
        }

        $error = $_SESSION['flash_error'] ?? null;
        unset($_SESSION['flash_error']);

        $this->renderPlain('auth/register', ['error' => $error]);
    }

    public function register(): void
    {
        $name = trim($_POST['name'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';
        $passwordConfirmation = $_POST['password_confirmation'] ?? '';

        if ($name === '' || $email === '' || $password === '') {
            $_SESSION['flash_error'] = 'Preencha todos os campos.';
            $this->redirect('/register');
            return;
        }

        if ($password !== $passwordConfirmation) {
            $_SESSION['flash_error'] = 'As senhas não coincidem.';
            $this->redirect('/register');
            return;
        }

        $userRepository = RepositoryFactory::make('user');

        if ($userRepository->emailExists($email)) {
            $_SESSION['flash_error'] = 'Este e-mail já está cadastrado.';
            $this->redirect('/register');
            return;
        }

        $hash = password_hash($password, PASSWORD_BCRYPT);
        $userId = $userRepository->create($name, $email, $hash);

        $_SESSION['user_id'] = $userId;
        $_SESSION['user_name'] = $name;

        $this->redirect('/dashboard');
    }

    public function logout(): void
    {
        $_SESSION = [];
        session_destroy();
        $this->redirect('/login');
    }
}
