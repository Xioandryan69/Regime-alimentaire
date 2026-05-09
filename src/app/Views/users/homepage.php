<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page user interfaces - My Régime</title>
    <!-- Bootstrap CSS -->
    <link href="<?= base_url('assets/bootstrap/css/bootstrap.min.css') ?>" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="<?= base_url('assets/css/style.css') ?>">
</head>
<body class="bg-light">

    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold text-success" href="#">My Régime</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#adminNavbar">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="adminNavbar">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="<?= base_url('users/homepage') ?>"><i class="fas fa-home me-1"></i> Accueil </a>
                    </li>
                </ul>
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarUser" role="button" data-bs-toggle="dropdown">
                            <i class="fas fa-user-circle me-1"></i> <?= esc(session()->get('username')) ?>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item text-danger" href="<?= base_url('users/logout') ?>"><i class="fas fa-sign-out-alt me-1"></i> Se déconnecter</a></li>
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
            
            <div class="row g-4 mb-5">
                <!-- Chiffres clés -->
                <div class="col-md-4">
                    <div class="card shadow-sm border-0 bg-success text-white h-100">
                        <div class="card-body text-center">
                            <h5 class="card-title"><i class="fas fa-users me-2"></i> Utilisateurs Inscrits</h5>
                            <p class="card-text display-4 fw-bold"><?= $nbUsers ?></p>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="card shadow-sm border-0 bg-primary text-white h-100">
                        <div class="card-body text-center">
                            <h5 class="card-title"><i class="fas fa-chart-line me-2"></i> Revenus Totaux</h5>
                            <!-- Formatage du prix en Ariary (ou ta monnaie) -->
                            <p class="card-text display-4 fw-bold"><?= number_format($revenus, 0, ',', ' ') ?> Ar</p> 
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card shadow-sm border-0 bg-info text-white h-100">
                        <div class="card-body text-center">
                            <h5 class="card-title"><i class="fas fa-clipboard-list me-2"></i> Régimes Vendus</h5>
                            <p class="card-text display-4 fw-bold"><?= $nbRegimesVendus ?></p>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Statistiques Graphiques -->
            <div class="row g-4">
                <div class="col-md-8">
                    <div class="card shadow-sm border-0 h-100">
                        <div class="card-header bg-white py-3">
                            <h5 class="mb-0 fw-bold"><i class="fas fa-money-bill-wave me-2"></i> Évolution des revenus</h5>
                        </div>
                        <div class="card-body">
                            <canvas id="revenusChart"></canvas>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="card shadow-sm border-0 h-100">
                        <div class="card-header bg-white py-3">
                            <h5 class="mb-0 fw-bold"><i class="fas fa-bullseye me-2"></i> Répartition des objectifs</h5>
                        </div>
                        <div class="card-body">
                            <canvas id="objectifsChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-dark text-white py-4 mt-5">
        <div class="container text-center">
            <p class="mb-0">&copy; 2026 My Régime</p>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="<?= base_url('assets/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>    
</body>
</html>