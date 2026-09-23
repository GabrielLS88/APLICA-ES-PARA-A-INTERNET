<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Factories\RepositoryFactory;

/**
 * Tela própria com CRUD completo: gerenciamento de Eventos (Eventos do Fly Eventos).
 */
class EventController extends Controller
{
    public function index(): void
    {
        $this->requireAuth();

        $eventRepository = RepositoryFactory::make('event');
        $events = $eventRepository->allByUser((int) $_SESSION['user_id']);

        $this->render('events/index', ['events' => $events]);
    }

    public function create(): void
    {
        $this->requireAuth();
        $this->render('events/create', ['errors' => [], 'old' => []]);
    }

    public function store(): void
    {
        $this->requireAuth();

        [$name, $description, $eventDate, $location, $errors] = $this->validate($_POST);

        if (!empty($errors)) {
            $this->render('events/create', ['errors' => $errors, 'old' => $_POST]);
            return;
        }

        $eventRepository = RepositoryFactory::make('event');
        $eventRepository->create((int) $_SESSION['user_id'], $name, $description, $eventDate, $location);

        $this->redirect('/events');
    }

    public function edit(string $id): void
    {
        $this->requireAuth();

        $eventRepository = RepositoryFactory::make('event');
        $event = $eventRepository->find((int) $id, (int) $_SESSION['user_id']);

        if (!$event) {
            $this->redirect('/events');
            return;
        }

        $this->render('events/edit', ['event' => $event, 'errors' => []]);
    }

    public function update(string $id): void
    {
        $this->requireAuth();

        [$name, $description, $eventDate, $location, $errors] = $this->validate($_POST);
        $eventRepository = RepositoryFactory::make('event');

        if (!empty($errors)) {
            $event = $eventRepository->find((int) $id, (int) $_SESSION['user_id']);
            $this->render('events/edit', ['errors' => $errors, 'event' => $event]);
            return;
        }

        $eventRepository->update(
            (int) $id,
            (int) $_SESSION['user_id'],
            $name,
            $description,
            $eventDate,
            $location
        );

        $this->redirect('/events');
    }

    public function destroy(string $id): void
    {
        $this->requireAuth();

        $eventRepository = RepositoryFactory::make('event');
        $eventRepository->delete((int) $id, (int) $_SESSION['user_id']);

        $this->redirect('/events');
    }

    private function validate(array $data): array
    {
        $name = trim($data['name'] ?? '');
        $description = trim($data['description'] ?? '');
        $eventDate = trim($data['event_date'] ?? '');
        $location = trim($data['location'] ?? '');

        $errors = [];
        if ($name === '') {
            $errors[] = 'O nome do evento é obrigatório.';
        }
        if ($eventDate === '') {
            $errors[] = 'A data do evento é obrigatória.';
        }

        return [$name, $description, $eventDate, $location, $errors];
    }
}
