<?php
require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/Controllers/AuthController.php';
require_once __DIR__ . '/Controllers/DashboardController.php';
require_once __DIR__ . '/Controllers/TicketController.php';

session_start();

$loader = new \Twig\Loader\FilesystemLoader(__DIR__ . '/templates');
$twig = new \Twig\Environment($loader);

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

switch ($uri) {
    case '/':
        echo $twig->render('landing.twig', ['session' => $_SESSION['user'] ?? null]);
        break;

    case '/login':
        showLogin($twig);
        break;

    case '/signup':
        showSignup($twig);
        break;

    case '/dashboard':
        showDashboard($twig);
        break;

    case '/tickets':
        showTickets($twig);
        break;

    case '/logout':
        session_destroy();
        header('Location: /');
        break;

    default:
        http_response_code(404);
        echo $twig->render('layout.twig', [
            'title' => '404 Not Found',
            'session' => $_SESSION['user'] ?? null,
        ]);
}