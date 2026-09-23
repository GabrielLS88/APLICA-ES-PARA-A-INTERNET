<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="mb-0">Minhas Tarefas</h2>
    <a href="/events" class="btn btn-success">&#9992; Ir para Eventos</a>
</div>

<div class="card mb-4 shadow-sm">
    <div class="card-body">
        <form method="POST" action="/tasks" class="row g-2">
            <div class="col-md-4">
                <input type="text" name="title" class="form-control" placeholder="T&iacute;tulo da tarefa" required>
            </div>
            <div class="col-md-6">
                <input type="text" name="description" class="form-control" placeholder="Descri&ccedil;&atilde;o (opcional)">
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary w-100">Adicionar</button>
            </div>
        </form>
    </div>
</div>

<?php if (empty($tasks)): ?>
    <div class="alert alert-info">Voc&ecirc; ainda n&atilde;o tem tarefas cadastradas.</div>
<?php else: ?>
    <ul class="list-group shadow-sm">
        <?php foreach ($tasks as $task): ?>
            <li class="list-group-item d-flex justify-content-between align-items-start">
                <div class="me-3">
                    <div class="<?= $task->isCompleted ? 'text-decoration-line-through text-muted' : '' ?> fw-semibold">
                        <?= htmlspecialchars($task->title) ?>
                    </div>
                    <?php if ($task->description): ?>
                        <small class="text-muted"><?= htmlspecialchars($task->description) ?></small>
                    <?php endif; ?>
                </div>
                <div class="d-flex gap-2">
                    <form method="POST" action="/tasks/<?= $task->id ?>/toggle">
                        <button type="submit" class="btn btn-sm btn-outline-secondary">
                            <?= $task->isCompleted ? 'Reabrir' : 'Concluir' ?>
                        </button>
                    </form>
                    <form method="POST" action="/tasks/<?= $task->id ?>/delete"
                          onsubmit="return confirm('Remover esta tarefa?');">
                        <button type="submit" class="btn btn-sm btn-outline-danger">Excluir</button>
                    </form>
                </div>
            </li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>
