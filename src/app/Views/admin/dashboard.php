<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de Bord Administration - My Régime</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="<?= base_url('assets/css/style.css') ?>">
</head>
<body class="bg-light">

    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold text-success" href="#">My Régime - Admin</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#adminNavbar">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="adminNavbar">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="<?= base_url('admin/dashboard') ?>"><i class="fas fa-home me-1"></i> Tableau de bord</a>
                    </li>
                </ul>
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarUser" role="button" data-bs-toggle="dropdown">
                            <i class="fas fa-user-circle me-1"></i> <?= esc(session()->get('username')) ?>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item text-danger" href="<?= base_url('admin/logout') ?>"><i class="fas fa-sign-out-alt me-1"></i> Se déconnecter</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Dashboard Content -->
    <section class="py-5">
        <div class="container">
            <h1 class="mb-4 fw-bold">Tableau de bord</h1>
            
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="card shadow-sm border-0 bg-success text-white">
                        <div class="card-body">
                            <h5 class="card-title"><i class="fas fa-users me-2"></i> Utilisateurs</h5>
                            <p class="card-text display-4 fw-bold">120</p>
                            <a href="#" class="btn btn-outline-light btn-sm">Gérer</a>
                        </div>
                    </div>
                </div>
                <!-- Vous pourrez ajouter d'autres cartes de statistiques ici -->
            </div>
            
            <div class="card shadow-sm border-0 mt-5">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 fw-bold"><i class="fas fa-chart-line me-2"></i> Activité récente</h5>
                </div>
                <div class="card-body">
                    <p class="text-muted">Bienvenue sur votre espace d'administration. Vous pouvez gérer les régimes, les utilisateurs et le contenu de l'application depuis cet espace.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-dark text-white py-4 mt-5 fixed-bottom">
        <div class="container text-center">
            <p class="mb-0">&copy; 2026 My Régime. Espace Administration.</p>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>