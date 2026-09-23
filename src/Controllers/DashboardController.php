<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Factories\RepositoryFactory;

class DashboardController extends Controller
{
    public function index(): void
    {
        $this->requireAuth();

        $taskRepository = RepositoryFactory::make('task');
        $tasks = $taskRepository->allByUser((int) $_SESSION['user_id']);

        $this->render('dashboard/index', ['tasks' => $tasks]);
    }

    public function store(): void
    {
        $this->requireAuth();

        $title = trim($_POST['title'] ?? '');
        $description = trim($_POST['description'] ?? '');

        if ($title !== '') {
            $taskRepository = RepositoryFactory::make('task');
            $taskRepository->create((int) $_SESSION['user_id'], $title, $description);
        }

        $this->redirect('/dashboard');
    }

    public function toggle(string $id): void
    {
        $this->requireAuth();

        $taskRepository = RepositoryFactory::make('task');
        $taskRepository->toggleComplete((int) $id, (int) $_SESSION['user_id']);

        $this->redirect('/dashboard');
    }

    public function destroy(string $id): void
    {
        $this->requireAuth();

        $taskRepository = RepositoryFactory::make('task');
        $taskRepository->delete((int) $id, (int) $_SESSION['user_id']);

        $this->redirect('/dashboard');
    }
}
