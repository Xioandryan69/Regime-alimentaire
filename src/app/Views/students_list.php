<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>SysInfo — Liste etudiants</title>
  <link rel="stylesheet" href="<?= base_url('assets/style.css') ?>" />
</head>
<body>

<div class="app">
  <aside class="sidebar">
    <div class="sidebar-brand">
      <div class="logo-icon">
        <svg viewBox="0 0 24 24" width="18" height="18"><path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/></svg>
      </div>
      <div>
        <div class="brand-name">SysInfo</div>
        <div class="brand-sub">Notes S3/S4</div>
      </div>
    </div>

    <div class="sidebar-section">Navigation</div>
    <a href="/students" class="nav-item active">
      <svg viewBox="0 0 24 24"><line x1="8" y1="6" x2="21" y2="6"/><line x1="8" y1="12" x2="21" y2="12"/><line x1="8" y1="18" x2="21" y2="18"/><line x1="3" y1="6" x2="3.01" y2="6"/><line x1="3" y1="12" x2="3.01" y2="12"/><line x1="3" y1="18" x2="3.01" y2="18"/></svg>
      Liste etudiants
    </a>
    <a href="/notes/new" class="nav-item">
      <svg viewBox="0 0 24 24"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
      Ajouter une note
    </a>

    <div class="sidebar-bottom">
      <a href="/login" class="user-row">
        <div class="avatar">AD</div>
        <div class="user-info">
          <div class="name">Admin Sys</div>
          <div class="role">Pedagogie</div>
        </div>
      </a>
    </div>
  </aside>

  <div class="main">
    <div class="topbar">
      <div class="topbar-title">Liste des etudiants</div>
      <div class="topbar-actions">
        <a href="/notes/new" class="btn btn-primary btn-sm">Saisir des notes</a>
      </div>
    </div>

    <div class="content">
      <div class="page-header">
        <div>
          <h2>Etudiants</h2>
          <div class="breadcrumb">Accueil / <span>Liste</span></div>
        </div>
      </div>

      <div class="table-card">
        <table>
          <thead>
            <tr>
              <th>Etudiant</th>
              <th>Email</th>
              <th>Voir notes</th>
            </tr>
          </thead>
          <tbody>
            <?php if (empty($students)) : ?>
              <tr>
                <td colspan="4" class="empty-state">Aucun etudiant pour le moment.</td>
              </tr>
            <?php endif; ?>

            <?php foreach ($students as $student) : ?>
              <tr>
                <td>
                  <div class="row-user">
                    <div class="avatar-sm"><?= esc(strtoupper(substr($student['prenom'], 0, 1) . substr($student['nom'], 0, 1))) ?></div>
                    <div>
                      <div class="row-title"><?= esc($student['nom']) ?> <?= esc($student['prenom']) ?></div>
                      <div class="row-sub">ID <?= esc($student['id']) ?></div>
                    </div>
                  </div>
                </td>
                <td><?= esc($student['email']) ?></td>
                <td>
                  <a href="/students/<?= esc($student['id']) ?>" class="btn btn-ghost btn-sm">Voir</a>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<script src="<?= base_url('assets/script.js') ?>"></script>
</body>
</html>
