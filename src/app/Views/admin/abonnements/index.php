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
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="fw-bold">Paramètres d’abonnement</h2>
                <a href="<?= base_url('admin/abonnements/create') ?>" class="btn btn-success"><i class="fas fa-plus me-1"></i> Nouveau type</a>
            </div>

            <?php if(session()->getFlashdata('success')): ?>
                <div class="alert alert-success">
                    <i class="fas fa-check-circle me-2"></i> <?= session()->getFlashdata('success') ?>
                </div>
            <?php endif; ?>
            <?php if(session()->getFlashdata('error')): ?>
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-circle me-2"></i> <?= session()->getFlashdata('error') ?>
                </div>
            <?php endif; ?>

            <div class="card shadow-sm border-0">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover table-striped mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>ID</th>
                                    <th>Code</th>
                                    <th>Nom</th>
                                    <th>Prix</th>
                                    <th>Remise</th>
                                    <th>Durée (jours)</th>
                                    <th>Actif</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($plans as $plan): ?>
                                <tr>
                                    <td><?= esc($plan['id']) ?></td>
                                    <td><?= esc($plan['code']) ?></td>
                                    <td><?= esc($plan['nom']) ?></td>
                                    <td><span class="badge bg-success"><?= number_format($plan['prix'], 2, ',', ' ') ?> Ar</span></td>
                                    <td><?= esc($plan['remise']) ?>%</td>
                                    <td><?= esc($plan['duree_jours']) ?: '—' ?></td>
                                    <td>
                                        <?php if($plan['actif']): ?>
                                            <span class="badge bg-success">Oui</span>
                                        <?php else: ?>
                                            <span class="badge bg-secondary">Non</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-center">
                                        <div class="btn-group" role="group">
                                            <a href="<?= base_url('admin/abonnements/edit/'.$plan['id']) ?>" class="btn btn-sm btn-primary" title="Modifier"><i class="fas fa-edit"></i> Modifier</a>
                                            <a href="<?= base_url('admin/abonnements/delete/'.$plan['id']) ?>" class="btn btn-sm btn-danger" title="Supprimer" onclick="return confirm('Supprimer ce type d\'abonnement ?');"><i class="fas fa-trash-alt"></i> Supprimer</a>
                                        </div>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                                <?php if(empty($plans)): ?>
                                    <tr>
                                        <td colspan="8" class="text-center py-4 text-muted">Aucun paramètre d'abonnement trouvé.</td>
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
