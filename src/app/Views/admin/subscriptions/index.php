<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des abonnements - Administration</title>
    <link href="<?= base_url('assets/bootstrap/css/bootstrap.min.css') ?>" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('assets/fontawesome/css/all.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/style.css') ?>">
</head>
<body class="bg-light">

    <?= $this->include('admin/templates/navbar') ?>

    <section class="py-5">
        <div class="container">
            <h2 class="fw-bold mb-4">Gestion des abonnements utilisateurs</h2>

            <?php if(session()->getFlashdata('success')): ?>
                <div class="alert alert-success alert-dismissible fade show">
                    <i class="fas fa-check-circle me-2"></i> <?= session()->getFlashdata('success') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>
            <?php if(session()->getFlashdata('error')): ?>
                <div class="alert alert-danger alert-dismissible fade show">
                    <i class="fas fa-exclamation-circle me-2"></i> <?= session()->getFlashdata('error') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <div class="card shadow-sm border-0">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover table-striped mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>ID</th>
                                    <th>Nom & Prénom</th>
                                    <th>Email</th>
                                    <th>Abonnement actif</th>
                                    <th>Début</th>
                                    <th>Fin</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($users as $user): ?>
                                <tr>
                                    <td><?= esc($user['id']) ?></td>
                                    <td><?= esc($user['nom']) ?> <?= esc($user['prenom']) ?></td>
                                    <td><?= esc($user['email']) ?></td>
                                    <td>
                                        <?php if(!empty($user['abonnement_type'])): ?>
                                            <?php if($user['abonnement_type'] === 'GOLD'): ?>
                                                <span class="badge bg-warning text-dark">GOLD 👑</span>
                                            <?php else: ?>
                                                <span class="badge bg-secondary">FREE</span>
                                            <?php endif; ?>
                                        <?php else: ?>
                                            <span class="badge bg-light text-dark">Aucun</span>
                                        <?php endif; ?>
                                    </td>
                                    <td><small><?= !empty($user['date_debut']) ? date('d/m/Y', strtotime($user['date_debut'])) : '—' ?></small></td>
                                    <td><small><?= !empty($user['date_fin']) ? date('d/m/Y', strtotime($user['date_fin'])) : '—' ?></small></td>
                                    <td class="text-center">
                                        <div class="btn-group btn-group-sm" role="group">
                                            <a href="<?= base_url('admin/subscriptions/assign/'.$user['id']) ?>" class="btn btn-primary" title="Assigner"><i class="fas fa-crown"></i> Assigner</a>
                                            <?php if(!empty($user['abonnement_id'])): ?>
                                                <a href="<?= base_url('admin/subscriptions/delete/'.$user['id']) ?>" class="btn btn-danger" title="Supprimer" onclick="return confirm('Supprimer cet abonnement ?');"><i class="fas fa-trash"></i></a>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                                <?php if(empty($users)): ?>
                                    <tr>
                                        <td colspan="7" class="text-center py-4 text-muted">Aucun utilisateur trouvé.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script src="<?= base_url('assets/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
</body>
</html>
