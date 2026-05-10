<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Créer un abonnement - Administration</title>
    <link href="<?= base_url('assets/bootstrap/css/bootstrap.min.css') ?>" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('assets/fontawesome/css/all.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/style.css') ?>">
</head>
<body class="bg-light">

    <?= $this->include('admin/templates/navbar') ?>

    <section class="py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="card shadow-sm border-0">
                        <div class="card-header bg-white py-3">
                            <h3 class="mb-0 fw-bold">Ajouter un type d'abonnement</h3>
                        </div>
                        <div class="card-body">
                            <form action="<?= base_url('admin/abonnements/store') ?>" method="post">
                                <?= csrf_field() ?>
                                <div class="mb-3">
                                    <label for="code" class="form-label fw-bold">Code</label>
                                    <input type="text" class="form-control" id="code" name="code" placeholder="FREE ou GOLD" required>
                                </div>
                                <div class="mb-3">
                                    <label for="nom" class="form-label fw-bold">Nom</label>
                                    <input type="text" class="form-control" id="nom" name="nom" placeholder="Abonnement Gold" required>
                                </div>
                                <div class="mb-3">
                                    <label for="description" class="form-label fw-bold">Description</label>
                                    <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                                </div>
                                <div class="row g-3">
                                    <div class="col-md-4 mb-3">
                                        <label for="prix" class="form-label fw-bold">Prix (Ar)</label>
                                        <input type="number" step="0.01" class="form-control" id="prix" name="prix" value="0.00" required>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="remise" class="form-label fw-bold">Remise (%)</label>
                                        <input type="number" step="0.01" class="form-control" id="remise" name="remise" value="0.00" required>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="duree_jours" class="form-label fw-bold">Durée (jours)</label>
                                        <input type="number" class="form-control" id="duree_jours" name="duree_jours" placeholder="365">
                                    </div>
                                </div>
                                <div class="form-check form-switch mb-4">
                                    <input class="form-check-input" type="checkbox" id="actif" name="actif" checked>
                                    <label class="form-check-label" for="actif">Actif</label>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <a href="<?= base_url('admin/abonnements') ?>" class="btn btn-outline-secondary"><i class="fas fa-arrow-left me-1"></i> Retour</a>
                                    <button type="submit" class="btn btn-success"><i class="fas fa-save me-1"></i> Enregistrer</button>
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
