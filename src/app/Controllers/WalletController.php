<?php

namespace App\Controllers;

use App\Models\WalletModel;
use CodeIgniter\RESTful\ResourceController;

class WalletController extends ResourceController
{
    protected $walletModel;

    public function __construct()
    {
        $this->walletModel = new WalletModel();
    }

    /**
     * Liste tous les wallets
     */
    public function index()
    {
        $data = $this->walletModel->findAll();

        return $this->respond([
            'success' => true,
            'data' => $data
        ]);
    }

    /**
     * Voir wallet d’un utilisateur
     */
    public function show($user_id = null)
    {
        $wallet = $this->walletModel
            ->where('user_id', $user_id)
            ->first();

        if (!$wallet) {
            return $this->failNotFound("Wallet introuvable");
        }

        return $this->respond([
            'success' => true,
            'data' => $wallet
        ]);
    }

    /**
     * Créer ou récupérer wallet utilisateur
     */
    public function getOrCreate($user_id)
    {
        $wallet = $this->walletModel->getOuCreerParUser((int)$user_id);

        return $this->respond([
            'success' => true,
            'data' => $wallet
        ]);
    }

    /**
     * Créditer wallet
     */
    public function credit()
    {
        $user_id = $this->request->getPost('user_id');
        $montant = (float) $this->request->getPost('montant');

        if (!$user_id || $montant <= 0) {
            return $this->failValidationErrors("Données invalides");
        }

        $result = $this->walletModel->crediter($user_id, $montant);

        if (!$result) {
            return $this->failServerError("Erreur lors du crédit");
        }

        return $this->respond([
            'success' => true,
            'message' => 'Compte crédité'
        ]);
    }

    /**
     * Débiter wallet
     */
    public function debit()
    {
        $user_id = $this->request->getPost('user_id');
        $montant = (float) $this->request->getPost('montant');

        if (!$user_id || $montant <= 0) {
            return $this->failValidationErrors("Données invalides");
        }

        $result = $this->walletModel->debiter($user_id, $montant);

        if (!$result) {
            return $this->failValidationErrors("Solde insuffisant");
        }

        return $this->respond([
            'success' => true,
            'message' => 'Débit effectué'
        ]);
    }

    /**
     * Supprimer wallet
     */
    public function delete($id = null)
    {
        $wallet = $this->walletModel->find($id);

        if (!$wallet) {
            return $this->failNotFound("Wallet introuvable");
        }

        $this->walletModel->delete($id);

        return $this->respondDeleted([
            'success' => true,
            'message' => 'Wallet supprimé'
        ]);
    }
}