<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Créer un Régime - Administration</title>
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
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card shadow-sm border-0">
                        <div class="card-header bg-success text-white py-3">
                            <h5 class="mb-0 fw-bold"><i class="fas fa-plus-circle me-2"></i> Ajouter un nouveau régime</h5>
                        </div>
                        <div class="card-body p-4">
                            <form action="<?= base_url('admin/regimes/store') ?>" method="post">
                                <?= csrf_field() ?>
                                
                                <div class="mb-3">
                                    <label for="nom" class="form-label fw-bold">Nom du régime</label>
                                    <input type="text" class="form-control" id="nom" name="nom" required placeholder="Ex: Régime hyper-protéiné">
                                </div>

                                <div class="mb-3">
                                    <label for="description" class="form-label fw-bold">Description courte</label>
                                    <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-4">
                                        <label for="calories" class="form-label fw-bold">Calories (par jour)</label>
                                        <input type="number" class="form-control" id="calories" name="calories" required>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="duree_jours" class="form-label fw-bold">Durée (en jours)</label>
                                        <input type="number" class="form-control" id="duree_jours" name="duree_jours" required>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="prix" class="form-label fw-bold">Prix (Ar)</label>
                                        <input type="number" step="0.01" class="form-control" id="prix" name="prix" required>
                                    </div>
                                </div>

                                <div class="d-flex justify-content-between mt-4">
                                    <a href="<?= base_url('admin/regimes') ?>" class="btn btn-outline-secondary"><i class="fas fa-arrow-left me-1"></i> Annuler</a>
                                    <button type="submit" class="btn btn-success"><i class="fas fa-save me-1"></i> Créer le régime</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script src="<?= base_url('assets/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
</body>
</html>