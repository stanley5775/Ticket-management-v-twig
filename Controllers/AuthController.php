<?php


function showLogin($twig)
{
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $email = trim($_POST['email']);
        $password = trim($_POST['password']);

        // Fake user for demo purposes
        $demoUser = ['email' => 'user@example.com', 'password' => '123456'];

        if ($email === $demoUser['email'] && $password === $demoUser['password']) {
            $_SESSION['user'] = $email;
            header('Location: /dashboard');
            exit;
        } else {
            echo $twig->render('login.twig', [
                'error' => 'Invalid credentials. Try user@example.com / 123456',
                'session' => null
            ]);
            return;
        }
    }

    echo $twig->render('login.twig', ['session' => $_SESSION['user'] ?? null]);
}

function showSignup($twig)
{
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $email = trim($_POST['email']);
        $password = trim($_POST['password']);

        if (empty($email) || empty($password)) {
            echo $twig->render('signup.twig', [
                'error' => 'All fields are required!',
                'session' => null
            ]);
            return;
        }

        // Simulate successful signup
        $_SESSION['user'] = $email;
        header('Location: /dashboard');
        exit;
    }

    echo $twig->render('signup.twig', ['session' => $_SESSION['user'] ?? null]);
}