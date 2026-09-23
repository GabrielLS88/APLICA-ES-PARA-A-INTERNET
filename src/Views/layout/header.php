<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fly Eventos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<nav class="navbar navbar-expand-lg navbar-dark bg-primary mb-4">
    <div class="container">
        <a class="navbar-brand fw-bold" href="/dashboard">&#9992; Fly Eventos</a>
        <div class="d-flex align-items-center">
            <a class="btn btn-outline-light btn-sm me-2" href="/dashboard">Dashboard</a>
            <a class="btn btn-outline-light btn-sm me-2" href="/events">Eventos</a>
            <span class="navbar-text text-white me-3">
                Ol&aacute;, <?= htmlspecialchars($_SESSION['user_name'] ?? '') ?>
            </span>
            <form action="/logout" method="POST" class="d-inline m-0">
                <button class="btn btn-light btn-sm" type="submit">Sair</button>
            </form>
        </div>
    </div>
</nav>
<div class="container pb-5">
