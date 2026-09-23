<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="mb-0">Meus Eventos</h2>
    <a href="/events/create" class="btn btn-primary">+ Novo Evento</a>
</div>

<?php if (empty($events)): ?>
    <div class="alert alert-info">Nenhum evento cadastrado ainda. Clique em "Novo Evento" para come&ccedil;ar.</div>
<?php else: ?>
    <div class="table-responsive shadow-sm">
        <table class="table table-hover bg-white align-middle mb-0">
            <thead class="table-primary">
                <tr>
                    <th>Nome</th>
                    <th>Data</th>
                    <th>Local</th>
                    <th>Descri&ccedil;&atilde;o</th>
                    <th class="text-end">A&ccedil;&otilde;es</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($events as $event): ?>
                    <tr>
                        <td class="fw-semibold"><?= htmlspecialchars($event->name) ?></td>
                        <td><?= htmlspecialchars(date('d/m/Y H:i', strtotime($event->eventDate))) ?></td>
                        <td><?= htmlspecialchars($event->location ?? '-') ?></td>
                        <td><?= htmlspecialchars($event->description ?? '-') ?></td>
                        <td class="text-end">
                            <a href="/events/<?= $event->id ?>/edit" class="btn btn-sm btn-outline-secondary">Editar</a>
                            <form method="POST" action="/events/<?= $event->id ?>/delete" class="d-inline"
                                  onsubmit="return confirm('Remover este evento?');">
                                <button type="submit" class="btn btn-sm btn-outline-danger">Excluir</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php endif; ?>
