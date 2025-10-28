<?php


function showTickets($twig)
{
    if (!isset($_SESSION['user'])) {
        header('Location: /login');
        exit;
    }

    if (!isset($_SESSION['tickets'])) {
        $_SESSION['tickets'] = [];
    }

    // CREATE
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'create') {
        $title = trim($_POST['title']);
        $status = trim($_POST['status']);
        $description = trim($_POST['description']);

        if (empty($title) || empty($status)) {
            $_SESSION['flash'] = ['type' => 'error', 'message' => 'Title and status are required.'];
            header('Location: /tickets');
            exit;
        }

        $_SESSION['tickets'][] = [
            'id' => uniqid(),
            'title' => $title,
            'status' => $status,
            'description' => $description,
        ];

        $_SESSION['flash'] = ['type' => 'success', 'message' => 'Ticket added successfully!'];
        header('Location: /tickets');
        exit;
    }

    //  UPDATE
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'update') {
        $id = $_POST['id'];
        $title = trim($_POST['title']);
        $status = trim($_POST['status']);
        $description = trim($_POST['description']);

        foreach ($_SESSION['tickets'] as &$ticket) {
            if ($ticket['id'] === $id) {
                $ticket['title'] = $title;
                $ticket['status'] = $status;
                $ticket['description'] = $description;
                break;
            }
        }

        $_SESSION['flash'] = ['type' => 'success', 'message' => 'Ticket updated successfully!'];
        header('Location: /tickets');
        exit;
    }

    // DELETE
    if (isset($_GET['delete'])) {
        $id = $_GET['delete'];
        $_SESSION['tickets'] = array_filter($_SESSION['tickets'], fn($t) => $t['id'] !== $id);
        $_SESSION['flash'] = ['type' => 'delete', 'message' => 'Ticket deleted successfully!'];
        header('Location: /tickets');
        exit;
    }

    // EDIT FORM
    $editTicket = null;
    if (isset($_GET['edit'])) {
        $id = $_GET['edit'];
        foreach ($_SESSION['tickets'] as $t) {
            if ($t['id'] === $id) {
                $editTicket = $t;
                break;
            }
        }
    }

    $flash = $_SESSION['flash'] ?? null;
    unset($_SESSION['flash']); // Remove after one use

    echo $twig->render('tickets.twig', [
        'session' => $_SESSION['user'],
        'tickets' => $_SESSION['tickets'],
        'editTicket' => $editTicket,
        'flash' => $flash
    ]);
}