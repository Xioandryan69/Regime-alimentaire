<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>SysInfo — Notes etudiant</title>
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
    <a href="/notes/new" class="nav-item">
      <svg viewBox="0 0 24 24"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
      Ajouter une note
    </a>

    <div class="sidebar-section">Raccourcis</div>
    <a href="/students/<?= esc($student['id']) ?>?semester=S3" class="nav-item">
      <svg viewBox="0 0 24 24"><rect width="7" height="9" x="3" y="3" rx="1"/><rect width="7" height="5" x="14" y="3" rx="1"/><rect width="7" height="9" x="14" y="12" rx="1"/><rect width="7" height="5" x="3" y="16" rx="1"/></svg>
      Notes S3
    </a>
    <a href="/students/<?= esc($student['id']) ?>?semester=S4&option=dev" class="nav-item">
      <svg viewBox="0 0 24 24"><rect width="7" height="9" x="3" y="3" rx="1"/><rect width="7" height="5" x="14" y="3" rx="1"/><rect width="7" height="9" x="14" y="12" rx="1"/><rect width="7" height="5" x="3" y="16" rx="1"/></svg>
      S4 option dev
    </a>
    <a href="/students/<?= esc($student['id']) ?>?semester=S4&option=bddres" class="nav-item">
      <svg viewBox="0 0 24 24"><rect width="7" height="9" x="3" y="3" rx="1"/><rect width="7" height="5" x="14" y="3" rx="1"/><rect width="7" height="9" x="14" y="12" rx="1"/><rect width="7" height="5" x="3" y="16" rx="1"/></svg>
      S4 option bddres
    </a>
    <a href="/students/<?= esc($student['id']) ?>?semester=S4&option=web" class="nav-item">
      <svg viewBox="0 0 24 24"><rect width="7" height="9" x="3" y="3" rx="1"/><rect width="7" height="5" x="14" y="3" rx="1"/><rect width="7" height="9" x="14" y="12" rx="1"/><rect width="7" height="5" x="3" y="16" rx="1"/></svg>
      S4 option web
    </a>
    <a href="/students/<?= esc($student['id']) ?>?semester=L2&option=dev" class="nav-item">
      <svg viewBox="0 0 24 24"><rect width="7" height="9" x="3" y="3" rx="1"/><rect width="7" height="5" x="14" y="3" rx="1"/><rect width="7" height="9" x="14" y="12" rx="1"/><rect width="7" height="5" x="3" y="16" rx="1"/></svg>
      L2 option dev
    </a>
    <a href="/students/<?= esc($student['id']) ?>?semester=L2&option=bddres" class="nav-item">
      <svg viewBox="0 0 24 24"><rect width="7" height="9" x="3" y="3" rx="1"/><rect width="7" height="5" x="14" y="3" rx="1"/><rect width="7" height="9" x="14" y="12" rx="1"/><rect width="7" height="5" x="3" y="16" rx="1"/></svg>
      L2 option bddres
    </a>
    <a href="/students/<?= esc($student['id']) ?>?semester=L2&option=web" class="nav-item">
      <svg viewBox="0 0 24 24"><rect width="7" height="9" x="3" y="3" rx="1"/><rect width="7" height="5" x="14" y="3" rx="1"/><rect width="7" height="9" x="14" y="12" rx="1"/><rect width="7" height="5" x="3" y="16" rx="1"/></svg>
      L2 option web
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
      <div class="topbar-title">Notes etudiant</div>
      <div class="topbar-actions">
        <a href="/notes/new" class="btn btn-secondary btn-sm">Saisir note</a>
      </div>
    </div>

    <div class="content">
      <div class="page-header">
        <div>
          <h2><?= esc($student['nom']) ?> <?= esc($student['prenom']) ?></h2>
          <div class="breadcrumb">Parcours <span><?= esc($student['parcours_nom']) ?></span></div>
        </div>
        <div class="kpi-inline">
          <div>
            <div class="kpi-label">Moyenne S3</div>
            <div class="kpi-value"><?= $summaryS3['average'] !== null ? esc($summaryS3['average']) : '—' ?></div>
          </div>
          <div>
            <div class="kpi-label">Moyenne S4</div>
            <div class="kpi-value"><?= $summaryS4['average'] !== null ? esc($summaryS4['average']) : '—' ?></div>
          </div>
          <div>
            <div class="kpi-label">Moyenne L2</div>
            <div class="kpi-value"><?= $l2Average !== null ? esc($l2Average) : '—' ?></div>
          </div>
        </div>
        <div style="margin-top:10px;display:flex;gap:8px;flex-wrap:wrap">
          <span class="badge <?= $optionOverride === 'dev' ? 'badge-blue' : 'badge-gray' ?>">Option dev</span>
          <span class="badge <?= $optionOverride === 'bddres' ? 'badge-blue' : 'badge-gray' ?>">Option bddres</span>
          <span class="badge <?= $optionOverride === 'web' ? 'badge-blue' : 'badge-gray' ?>">Option web</span>
        </div>
      </div>

      <div class="tab-row">
        <a href="/students/<?= esc($student['id']) ?>?semester=S3" class="tab-item <?= $semester === 'S3' ? 'active' : '' ?>">S3</a>
        <a href="/students/<?= esc($student['id']) ?>?semester=S4&option=dev" class="tab-item <?= $semester === 'S4' && $optionOverride === 'dev' ? 'active' : '' ?>">S4 dev</a>
        <a href="/students/<?= esc($student['id']) ?>?semester=S4&option=bddres" class="tab-item <?= $semester === 'S4' && $optionOverride === 'bddres' ? 'active' : '' ?>">S4 bddres</a>
        <a href="/students/<?= esc($student['id']) ?>?semester=S4&option=web" class="tab-item <?= $semester === 'S4' && $optionOverride === 'web' ? 'active' : '' ?>">S4 web</a>
        <a href="/students/<?= esc($student['id']) ?>?semester=L2&option=dev" class="tab-item <?= $semester === 'L2' && $optionOverride === 'dev' ? 'active' : '' ?>">L2 dev</a>
        <a href="/students/<?= esc($student['id']) ?>?semester=L2&option=bddres" class="tab-item <?= $semester === 'L2' && $optionOverride === 'bddres' ? 'active' : '' ?>">L2 bddres</a>
        <a href="/students/<?= esc($student['id']) ?>?semester=L2&option=web" class="tab-item <?= $semester === 'L2' && $optionOverride === 'web' ? 'active' : '' ?>">L2 web</a>
      </div>

      <?php if ($semester === 'S3') : ?>
        <div class="card">
          <div class="card-header">
            <div class="card-title">Notes retenues — S3</div>
            <div class="card-sub">Regle: note max par matiere</div>
          </div>
          <div class="table-card flat">
            <table>
              <thead>
                <tr>
                  <th>Matiere</th>
                  <th>Type</th>
                  <th>Credits</th>
                  <th>Credits obtenus</th>
                  <th>Toutes notes</th>
                  <th>Note retenue</th>
                  <th>Changer note</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($summaryS3['rows'] as $row) : ?>
                  <tr>
                    <td><?= esc($row['name']) ?></td>
                    <td><?= $row['type'] === 'choix' ? 'Option' : 'Obligatoire' ?></td>
                    <td><?= esc($row['credits']) ?></td>
                    <td><?= esc($row['credits_obtained']) ?></td>
                    <td><?= !empty($row['all_notes']) ? esc(implode(' / ', $row['all_notes'])) : '—' ?></td>
                    <td><?= $row['grade'] !== null ? esc($row['grade']) : '—' ?></td>
                    <td>
                      <form action="/notes/retained" method="post" class="inline-form">
                        <?= csrf_field() ?>
                        <input type="hidden" name="student_id" value="<?= esc($student['id']) ?>" />
                        <input type="hidden" name="ue_id" value="<?= esc($row['ue_id']) ?>" />
                        <input type="number" name="grade" step="0.01" min="0" max="20" value="<?= $row['grade'] !== null ? esc($row['grade']) : '' ?>" class="input-sm" />
                        <button type="submit" class="btn btn-secondary btn-sm">OK</button>
                      </form>
                    </td>
                  </tr>
                <?php endforeach; ?>
              </tbody>
              <tfoot>
                <tr>
                  <td colspan="4"><strong>Total credits</strong></td>
                  <td colspan="3"><strong><?= esc($summaryS3['total_credits']) ?></strong></td>
                </tr>
                <tr>
                  <td colspan="4"><strong>Credits obtenus</strong></td>
                  <td colspan="3"><strong><?= esc($summaryS3['total_credits_obtained']) ?></strong></td>
                </tr>
              </tfoot>
            </table>
          </div>
        </div>
      <?php endif; ?>

      <?php if ($semester === 'S4') : ?>
        <div class="card">
          <div class="card-header">
            <div class="card-title">Notes retenues — S4</div>
            <div class="card-sub">Regle: note max par matiere, meilleure option retenue</div>
          </div>
          <div class="table-card flat">
            <table>
              <thead>
                <tr>
                  <th>Matiere</th>
                  <th>Type</th>
                  <th>Credits</th>
                  <th>Credits obtenus</th>
                  <th>Toutes notes</th>
                  <th>Note retenue</th>
                  <th>Changer note</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($summaryS4['rows'] as $row) : ?>
                  <tr>
                    <td><?= esc($row['name']) ?></td>
                    <td><?= $row['type'] === 'choix' ? 'Option' : 'Obligatoire' ?></td>
                    <td><?= esc($row['credits']) ?></td>
                    <td><?= esc($row['credits_obtained']) ?></td>
                    <td><?= !empty($row['all_notes']) ? esc(implode(' / ', $row['all_notes'])) : '—' ?></td>
                    <td><?= $row['grade'] !== null ? esc($row['grade']) : '—' ?></td>
                    <td>
                      <form action="/notes/retained" method="post" class="inline-form">
                        <?= csrf_field() ?>
                        <input type="hidden" name="student_id" value="<?= esc($student['id']) ?>" />
                        <input type="hidden" name="ue_id" value="<?= esc($row['ue_id']) ?>" />
                        <input type="number" name="grade" step="0.01" min="0" max="20" value="<?= $row['grade'] !== null ? esc($row['grade']) : '' ?>" class="input-sm" />
                        <button type="submit" class="btn btn-secondary btn-sm">OK</button>
                      </form>
                    </td>
                  </tr>
                <?php endforeach; ?>
              </tbody>
              <tfoot>
                <tr>
                  <td colspan="4"><strong>Total credits</strong></td>
                  <td colspan="3"><strong><?= esc($summaryS4['total_credits']) ?></strong></td>
                </tr>
                <tr>
                  <td colspan="4"><strong>Credits obtenus</strong></td>
                  <td colspan="3"><strong><?= esc($summaryS4['total_credits_obtained']) ?></strong></td>
                </tr>
              </tfoot>
            </table>
          </div>
        </div>
      <?php endif; ?>

      <?php if ($semester === 'L2') : ?>
        <div class="card">
          <div class="card-header">
            <div class="card-title">Notes retenues — S3</div>
          </div>
          <div class="table-card flat">
            <table>
              <thead>
                <tr>
                  <th>Matiere</th>
                  <th>Type</th>
                  <th>Credits</th>
                  <th>Credits obtenus</th>
                  <th>Toutes notes</th>
                  <th>Note retenue</th>
                  <th>Changer note</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($summaryS3['rows'] as $row) : ?>
                  <tr>
                    <td><?= esc($row['name']) ?></td>
                    <td><?= $row['type'] === 'choix' ? 'Option' : 'Obligatoire' ?></td>
                    <td><?= esc($row['credits']) ?></td>
                    <td><?= esc($row['credits_obtained']) ?></td>
                    <td><?= !empty($row['all_notes']) ? esc(implode(' / ', $row['all_notes'])) : '—' ?></td>
                    <td><?= $row['grade'] !== null ? esc($row['grade']) : '—' ?></td>
                    <td>
                      <form action="/notes/retained" method="post" class="inline-form">
                        <?= csrf_field() ?>
                        <input type="hidden" name="student_id" value="<?= esc($student['id']) ?>" />
                        <input type="hidden" name="ue_id" value="<?= esc($row['ue_id']) ?>" />
                        <input type="number" name="grade" step="0.01" min="0" max="20" value="<?= $row['grade'] !== null ? esc($row['grade']) : '' ?>" class="input-sm" />
                        <button type="submit" class="btn btn-secondary btn-sm">OK</button>
                      </form>
                    </td>
                  </tr>
                <?php endforeach; ?>
              </tbody>
              <tfoot>
                <tr>
                  <td colspan="4"><strong>Total credits</strong></td>
                  <td colspan="3"><strong><?= esc($summaryS3['total_credits']) ?></strong></td>
                </tr>
                <tr>
                  <td colspan="4"><strong>Credits obtenus</strong></td>
                  <td colspan="3"><strong><?= esc($summaryS3['total_credits_obtained']) ?></strong></td>
                </tr>
              </tfoot>
            </table>
          </div>
        </div>

        <div class="card">
          <div class="card-header">
            <div class="card-title">Notes retenues — S4</div>
          </div>
          <div class="table-card flat">
            <table>
              <thead>
                <tr>
                  <th>Matiere</th>
                  <th>Type</th>
                  <th>Credits</th>
                  <th>Credits obtenus</th>
                  <th>Toutes notes</th>
                  <th>Note retenue</th>
                  <th>Changer note</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($summaryS4['rows'] as $row) : ?>
                  <tr>
                    <td><?= esc($row['name']) ?></td>
                    <td><?= $row['type'] === 'choix' ? 'Option' : 'Obligatoire' ?></td>
                    <td><?= esc($row['credits']) ?></td>
                    <td><?= esc($row['credits_obtained']) ?></td>
                    <td><?= !empty($row['all_notes']) ? esc(implode(' / ', $row['all_notes'])) : '—' ?></td>
                    <td><?= $row['grade'] !== null ? esc($row['grade']) : '—' ?></td>
                    <td>
                      <form action="/notes/retained" method="post" class="inline-form">
                        <?= csrf_field() ?>
                        <input type="hidden" name="student_id" value="<?= esc($student['id']) ?>" />
                        <input type="hidden" name="ue_id" value="<?= esc($row['ue_id']) ?>" />
                        <input type="number" name="grade" step="0.01" min="0" max="20" value="<?= $row['grade'] !== null ? esc($row['grade']) : '' ?>" class="input-sm" />
                        <button type="submit" class="btn btn-secondary btn-sm">OK</button>
                      </form>
                    </td>
                  </tr>
                <?php endforeach; ?>
              </tbody>
              <tfoot>
                <tr>
                  <td colspan="4"><strong>Total credits</strong></td>
                  <td colspan="3"><strong><?= esc($summaryS4['total_credits']) ?></strong></td>
                </tr>
                <tr>
                  <td colspan="4"><strong>Credits obtenus</strong></td>
                  <td colspan="3"><strong><?= esc($summaryS4['total_credits_obtained']) ?></strong></td>
                </tr>
              </tfoot>
            </table>
          </div>
        </div>

        <div class="card">
          <div class="card-header">
            <div class="card-title">Moyenne generale L2</div>
            <div class="card-sub">(S3 + S4) / 2</div>
          </div>
          <div class="kpi-block">
            <div class="kpi-value"><?= $l2Average !== null ? esc($l2Average) : '—' ?></div>
          </div>
        </div>
      <?php endif; ?>

      <div class="card">
        <div class="card-header">
          <div class="card-title">Historique des saisies</div>
          <div class="card-sub">Toutes les notes saisies pour cet etudiant</div>
        </div>
        <div class="table-card flat">
          <table>
            <thead>
              <tr>
                <th>Date</th>
                <th>Semestre</th>
                <th>Matiere</th>
                <th>Option</th>
                <th>Note</th>
                <th>Supprimer</th>
              </tr>
            </thead>
            <tbody>
              <?php if (empty($history)) : ?>
                <tr>
                  <td colspan="6" class="empty-state">Aucune note saisie.</td>
                </tr>
              <?php endif; ?>
              <?php foreach ($history as $row) : ?>
                <tr>
                  <td><?= esc(substr($row['created_at'], 0, 10)) ?></td>
                  <td>S<?= esc($row['numero']) ?></td>
                  <td><?= esc($row['ue_nom']) ?></td>
                  <td><?= $row['type'] === 'choix' ? 'Choix ' . esc((string) $row['groupe_choix']) : '—' ?></td>
                  <td><?= esc($row['note']) ?></td>
                  <td>
                    <form action="/notes/<?= esc($row['id']) ?>/delete" method="post" class="inline-form">
                      <?= csrf_field() ?>
                      <input type="hidden" name="student_id" value="<?= esc($student['id']) ?>" />
                      <button type="submit" class="btn btn-danger btn-sm">Supprimer</button>
                    </form>
                  </td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>

    </div>
  </div>
</div>

<script src="<?= base_url('assets/script.js') ?>"></script>
</body>
</html>
