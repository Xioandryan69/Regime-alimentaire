<?php

namespace App\Controllers;

use App\Models\AbonnementModel;

class AdminAbonnements extends BaseController
{
    protected $abonnementModel;
    protected $db;

    public function __construct()
    {
        $this->abonnementModel = new AbonnementModel();
        $this->db = \Config\Database::connect();
    }

    public function index()
    {
        $query = "
            SELECT u.id, u.nom, u.prenom, u.email, a.type as abonnement_type, 
                   a.date_debut, a.date_fin, a.id as abonnement_id
            FROM users u
            LEFT JOIN abonnements a ON u.id = a.user_id 
                AND (a.date_fin IS NULL OR a.date_fin >= CURDATE())
            ORDER BY u.nom
        ";
        
        $users = $this->db->query($query)->getResultArray();

        return view('admin/subscriptions/index', ['users' => $users]);
    }

    public function assign($userId)
    {
        $user = $this->db->table('users')->where('id', $userId)->get()->getRow();

        if (!$user) {
            session()->setFlashdata('error', 'Utilisateur introuvable.');
            return redirect()->to('admin/subscriptions');
        }

        $currentSub = $this->abonnementModel->getActifParUser($userId);

        return view('admin/subscriptions/assign', [
            'user' => $user,
            'currentSub' => $currentSub,
            'types' => ['FREE', 'GOLD']
        ]);
    }

    public function save($userId)
    {
        $type = $this->request->getPost('type');
        $dureeJours = $this->request->getPost('duree_jours');

        if (!in_array($type, ['FREE', 'GOLD'])) {
            session()->setFlashdata('error', 'Type d\'abonnement invalide.');
            return redirect()->to('admin/subscriptions/assign/' . $userId);
        }

        try {
            $dateDebut = date('Y-m-d');
            $dateFin = null;

            if (!empty($dureeJours)) {
                $dateFin = date('Y-m-d', strtotime("+{$dureeJours} days"));
            }

            $existing = $this->abonnementModel->getActifParUser($userId);

            if ($existing) {
                $this->abonnementModel->update($existing['id'], [
                    'type' => $type,
                    'date_debut' => $dateDebut,
                    'date_fin' => $dateFin,
                ]);
            } else {
                $this->abonnementModel->insert([
                    'user_id' => $userId,
                    'type' => $type,
                    'date_debut' => $dateDebut,
                    'date_fin' => $dateFin,
                ]);
            }

            session()->setFlashdata('success', 'Abonnement assigné avec succès.');
        } catch (\Exception $e) {
            session()->setFlashdata('error', 'Erreur lors de l\'assignation : ' . $e->getMessage());
        }

        return redirect()->to('admin/subscriptions');
    }

    public function delete($userId)
    {
        try {
            $sub = $this->abonnementModel->getActifParUser($userId);

            if ($sub) {
                $this->abonnementModel->delete($sub['id']);
                session()->setFlashdata('success', 'Abonnement supprimé.');
            } else {
                session()->setFlashdata('error', 'Aucun abonnement actif trouvé.');
            }
        } catch (\Exception $e) {
            session()->setFlashdata('error', 'Erreur : ' . $e->getMessage());
        }

        return redirect()->to('admin/subscriptions');
    }
}
