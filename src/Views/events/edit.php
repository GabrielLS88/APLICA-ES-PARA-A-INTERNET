<h2 class="mb-4">Editar Evento</h2>

<?php if (!empty($errors)): ?>
    <div class="alert alert-danger">
        <ul class="mb-0">
            <?php foreach ($errors as $err): ?>
                <li><?= htmlspecialchars($err) ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<div class="card shadow-sm">
    <div class="card-body">
        <form method="POST" action="/events/<?= $event->id ?>">
            <div class="mb-3">
                <label class="form-label">Nome do evento</label>
                <input type="text" name="name" class="form-control" value="<?= htmlspecialchars($event->name) ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Data e hora</label>
                <input type="datetime-local" name="event_date" class="form-control"
                       value="<?= htmlspecialchars(date('Y-m-d\TH:i', strtotime($event->eventDate))) ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Local</label>
                <input type="text" name="location" class="form-control" value="<?= htmlspecialchars($event->location ?? '') ?>">
            </div>
            <div class="mb-3">
                <label class="form-label">Descri&ccedil;&atilde;o</label>
                <textarea name="description" class="form-control" rows="3"><?= htmlspecialchars($event->description ?? '') ?></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Atualizar Evento</button>
            <a href="/events" class="btn btn-outline-secondary">Cancelar</a>
        </form>
    </div>
</div>
