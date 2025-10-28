<?php


function showDashboard($twig)
{
    if (!isset($_SESSION['user'])) {
        header('Location: /login');
        exit;
    }

    // Example mock data
    $tickets = $_SESSION['tickets'] ?? [];

    $stats = [
        'total' => count($tickets),
        'open' => count(array_filter($tickets, fn($t) => $t['status'] === 'open')),
        'closed' => count(array_filter($tickets, fn($t) => $t['status'] === 'closed')),
    ];

    echo $twig->render('dashboard.twig', [
        'session' => $_SESSION['user'],
        'total' => $stats['total'],
        'open' => $stats['open'],
        'closed' => $stats['closed']
    ]);
}