<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Régimes - Administration</title>
    <!-- Bootstrap CSS -->
    <link href="<?= base_url('assets/bootstrap/css/bootstrap.min.css') ?>" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('assets/fontawesome/css/all.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/style.css') ?>">
</head>
<body class="bg-light">

    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold text-success" href="<?= base_url('admin/dashboard') ?>">My Régime - Admin</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#adminNavbar">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="adminNavbar">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url('admin/dashboard') ?>"><i class="fas fa-chart-pie me-1"></i> Tableau de bord</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url('admin/listUsers') ?>"><i class="fas fa-users me-1"></i> Utilisateurs</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url('admin/regimes') ?>"><i class="fas fa-utensils me-1"></i> Régimes</a>
                    </li>
                </ul>
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarUser" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-user-circle me-1"></i> <?= esc(session()->get('username') ?? 'Admin') ?>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item text-danger" href="<?= base_url('admin/logout') ?>"><i class="fas fa-sign-out-alt me-1"></i> Se déconnecter</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <section class="py-5">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="fw-bold">Liste des Régimes</h2>
                <a href="<?= base_url('admin/regimes/create') ?>" class="btn btn-success"><i class="fas fa-plus me-1"></i> Nouveau Régime</a>
            </div>

            <?php if(session()->getFlashdata('success')): ?>
                <div class="alert alert-success">
                    <i class="fas fa-check-circle me-2"></i> <?= session()->getFlashdata('success') ?>
                </div>
            <?php endif; ?>

            <div class="card shadow-sm border-0">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover table-striped mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>ID</th>
                                    <th>Nom</th>
                                    <th>Calories (jour)</th>
                                    <th>Durée</th>
                                    <th>Prix</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($regimes as $regime): ?>
                                <tr>
                                    <td><?= esc($regime['id']) ?></td>
                                    <td class="fw-bold text-primary"><?= esc($regime['nom']) ?></td>
                                    <td><?= esc($regime['calories']) ?> kcal</td>
                                    <td><?= esc($regime['duree_jours']) ?> jours</td>
                                    <td><span class="badge bg-success"><?= number_format($regime['prix'], 0, ',', ' ') ?> Ar</span></td>
                                    <td class="text-center">
                                        <div class="btn-group" role="group">
                                            <a href="<?= base_url('admin/regimes/edit/'.$regime['id']) ?>" class="btn btn-sm btn-primary" title="Modifier">
                                                <i class="fas fa-edit"></i> Modifier
                                            </a>
                                            <a href="<?= base_url('admin/regimes/delete/'.$regime['id']) ?>" class="btn btn-sm btn-danger" title="Supprimer" onclick="return confirm('Es-tu sûr de vouloir supprimer ce régime ?');">
                                                <i class="fas fa-trash-alt"></i> Supprimer
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                                <?php if(empty($regimes)): ?>
                                    <tr>
                                        <td colspan="6" class="text-center py-4 text-muted">Aucun régime trouvé.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Bootstrap JS -->
    <script src="<?= base_url('assets/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
</body>
</html>