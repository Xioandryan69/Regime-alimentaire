<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Assigner un abonnement</title>
    <link href="<?= base_url('assets/bootstrap/css/bootstrap.min.css') ?>" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('assets/fontawesome/css/all.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/style.css') ?>">
</head>
<body class="bg-light">

    <?= $this->include('admin/templates/navbar') ?>

    <section class="py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-7">
                    <div class="card shadow-sm border-0">
                        <div class="card-header bg-white py-3">
                            <h3 class="mb-0 fw-bold">
                                <i class="fas fa-crown me-2 text-warning"></i> Assigner un abonnement
                            </h3>
                        </div>
                        <div class="card-body">
                            <div class="mb-4 p-3 bg-light rounded">
                                <p class="mb-1"><strong>Utilisateur :</strong></p>
                                <p class="mb-0"><?= esc($user->nom) ?> <?= esc($user->prenom) ?> (<strong><?= esc($user->email) ?></strong>)</p>
                            </div>

                            <?php if(!empty($currentSub)): ?>
                                <div class="alert alert-info mb-4">
                                    <i class="fas fa-info-circle me-2"></i>
                                    <strong>Abonnement actuel :</strong> <?= esc($currentSub['type']) ?>
                                    <?php if(!empty($currentSub['date_fin'])): ?>
                                        jusqu'au <?= date('d/m/Y', strtotime($currentSub['date_fin'])) ?>
                                    <?php endif; ?>
                                </div>
                            <?php endif; ?>

                            <form action="<?= base_url('admin/subscriptions/save/'.$user->id) ?>" method="post">
                                <?= csrf_field() ?>

                                <div class="mb-4">
                                    <label for="type" class="form-label fw-bold">Type d'abonnement</label>
                                    <div>
                                        <div class="form-check mb-3">
                                            <input class="form-check-input" type="radio" id="type_free" name="type" value="FREE" checked>
                                            <label class="form-check-label" for="type_free">
                                                <strong>FREE</strong> - Gratuit (0% remise)
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" id="type_gold" name="type" value="GOLD">
                                            <label class="form-check-label" for="type_gold">
                                                <strong>GOLD 👑</strong> - Premium (15% remise sur les régimes)
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <label for="duree_jours" class="form-label fw-bold">Durée (en jours)</label>
                                    <small class="text-muted d-block mb-2">Laisser vide pour un abonnement sans limite</small>
                                    <input type="number" class="form-control" id="duree_jours" name="duree_jours" placeholder="365" min="1">
                                </div>

                                <div class="d-flex justify-content-between">
                                    <a href="<?= base_url('admin/subscriptions') ?>" class="btn btn-outline-secondary"><i class="fas fa-arrow-left me-1"></i> Retour</a>
                                    <button type="submit" class="btn btn-success"><i class="fas fa-save me-1"></i> Assigner</button>
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
