<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>SysInfo — Ajouter une note</title>
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
    <a href="/students" class="nav-item">
      <svg viewBox="0 0 24 24"><line x1="8" y1="6" x2="21" y2="6"/><line x1="8" y1="12" x2="21" y2="12"/><line x1="8" y1="18" x2="21" y2="18"/><line x1="3" y1="6" x2="3.01" y2="6"/><line x1="3" y1="12" x2="3.01" y2="12"/><line x1="3" y1="18" x2="3.01" y2="18"/></svg>
      Liste etudiants
    </a>
    <a href="/notes/new" class="nav-item active">
      <svg viewBox="0 0 24 24"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
      Ajouter une note
    </a>

    <div class="sidebar-section">S3 / S4</div>
    <div class="note-chip">Option dev</div>
    <div class="note-chip">Option bddres</div>
    <div class="note-chip">Option web</div>

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
      <div class="topbar-title">Ajouter des notes</div>
      <div class="topbar-actions">
        <a href="/students" class="btn btn-secondary btn-sm">Retour liste</a>
      </div>
    </div>

    <div class="content">
      <div class="page-header">
        <div>
          <h2>Nouvelle saisie</h2>
          <div class="breadcrumb">Saisie / <span>Notes</span></div>
        </div>
      </div>

      <?php if (!empty($message)) : ?>
        <div class="alert alert-success">
          <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><path d="M8 12l3 3 5-6"/></svg>
          <span><?= esc($message) ?></span>
        </div>
      <?php endif; ?>

      <?php if (!empty($errors)) : ?>
        <div class="alert alert-danger">
          <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
          <span><?= esc(implode(' ', $errors)) ?></span>
        </div>
      <?php endif; ?>

      <form action="/notes" method="post" class="card">
        <?= csrf_field() ?>
        <div class="form-grid cols-2">
          <div>
            <label class="field-label">Etudiant</label>
            <select name="student_id" required>
              <option value="">— Selectionner —</option>
              <?php foreach ($students as $student) : ?>
                <option value="<?= esc($student['id']) ?>">
                  <?= esc($student['nom']) ?> <?= esc($student['prenom']) ?> (<?= esc($student['parcours_nom']) ?>)
                </option>
              <?php endforeach; ?>
            </select>
          </div>
          <div>
            <label class="field-label">Date de saisie</label>
            <input type="date" value="<?= date('Y-m-d') ?>" disabled />
          </div>
        </div>

        <div class="note-rows" id="note-rows">
          <div class="note-row">
            <div>
              <label class="field-label">Matiere</label>
              <select name="subject_id[]" required>
                <option value="">— Selectionner —</option>
                <?php foreach ($subjects as $subject) : ?>
                  <option value="<?= esc($subject['ue_id']) ?>">
                    S<?= esc($subject['semestre_num']) ?> — <?= esc($subject['ue_nom']) ?>
                  </option>
                <?php endforeach; ?>
              </select>
            </div>
            <div>
              <label class="field-label">Note</label>
              <input type="number" name="grade[]" step="0.01" min="0" max="20" placeholder="0 - 20" required />
            </div>
            <div class="note-row-actions">
              <button type="button" class="btn btn-ghost btn-sm note-remove">Retirer</button>
            </div>
          </div>
        </div>

        <div class="note-actions">
          <button type="button" class="btn btn-secondary" id="add-note-row">Ajouter une note</button>
          <button type="submit" class="btn btn-primary">Enregistrer</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script src="<?= base_url('assets/script.js') ?>"></script>
</body>
</html>
