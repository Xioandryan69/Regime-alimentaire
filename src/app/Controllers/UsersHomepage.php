<?php

namespace App\Controllers;

use App\Models\CodeModel;
use App\Models\WalletModel;

class UsersHomepage extends BaseController
{
    protected CodeModel $codeModel;
    protected WalletModel $walletModel;

    public function __construct()
    {
        $this->codeModel = new CodeModel();
        $this->walletModel = new WalletModel();
    }

    public function index()
    {
        $db = \Config\Database::connect();
        
        $userNameQuery = "SELECT nom FROM users WHERE id = " . session()->get('id');
        $userName = $db->query($userNameQuery)->getRow()->nom ?? 'Utilisateur';

        $userLastNameQuery = "SELECT prenom FROM users WHERE id = " . session()->get('id');
        $userLastName = $db->query($userLastNameQuery)->getRow()->prenom ?? '';

        $userMailQuery = "SELECT email FROM users WHERE id = " . session()->get('id');
        $userMail = $db->query($userMailQuery)->getRow()->email ?? '';

        $userdateNaissanceQuery = "SELECT date_naissance FROM users WHERE id = " . session()->get('id');
        $dateNaissance = $db->query($userdateNaissanceQuery)->getRow()->date_naissance ?? '';
        $dateNaissance2 = new \DateTime($dateNaissance);
        $currentDate = new \DateTime();
        $userAge = $dateNaissance2->diff($currentDate)->y;

        $userTailleQuery = "SELECT taille FROM user_health WHERE user_id = " . session()->get('id');
        $userTaille = $db->query($userTailleQuery)->getRow()->taille ?? '';

        $userPoidsQuery = "SELECT poids FROM user_health WHERE user_id = " . session()->get('id');
        $userPoids = $db->query($userPoidsQuery)->getRow()->poids ?? 0;

        $userTailleMeters = (float)$userTaille;
        $userImc = ($userTailleMeters > 0) ? ($userPoids / ($userTailleMeters * $userTailleMeters)) : 0;

        $getObjectifId = "SELECT objectif_id FROM user_objectifs WHERE user_id = " . session()->get('id');
        $objectifRow = $db->query($getObjectifId)->getRow();
        $objectifId = $objectifRow ? $objectifRow->objectif_id : 0; 
        $userObjectif = '';
        if ($objectifId > 0) {
            $userObjectifQuerry = "SELECT nom FROM objectifs WHERE id = " . $objectifId;
            $userObjectif = $db->query($userObjectifQuerry)->getRow()->nom ?? '';
        }

        // Récupération des régimes et activités (recommandations suivies)
        $userActivitesRegimesQuery = "
            SELECT r.nom as regime_nom, a.nom as activite_nom, rec.date_debut, rec.date_fin 
            FROM recommendations rec
            LEFT JOIN regimes r ON rec.regime_id = r.id
            LEFT JOIN activites a ON rec.activite_id = a.id
            WHERE rec.user_id = " . session()->get('id') . "
            ORDER BY rec.date_debut DESC";
        $userProgrammes = $db->query($userActivitesRegimesQuery)->getResultArray();

        $wallet = $this->walletModel->getOuCreerParUser(session()->get('id'));

        $data = [
            'userName'        => $userName,
            'userLastName'    => $userLastName,
            'userMail'         => $userMail,
            'userAge'          => $userAge,
            'userTaille'       => $userTaille,
            'userPoids'        => $userPoids,
            'userImc'       => round($userImc, 2),
            'userObjectif' => $userObjectif,
            'userProgrammes' => $userProgrammes,
            'dateNaissance' => $dateNaissance,
            'userWalletSolde' => number_format((float)$wallet['solde'], 2, ',', ' '),
        ];

        return view('users/homepage', $data);
    }

    public function redeemCode()
    {
        $userId = session()->get('id');
        $codeString = trim($this->request->getPost('code_portefeuille'));

        if (empty($codeString)) {
            session()->setFlashdata('error', 'Veuillez saisir un code portefeuille.');
            return redirect()->to('users/homepage');
        }

        $code = $this->codeModel->trouverValide(strtolower($codeString));

        if (!$code) {
            session()->setFlashdata('error', 'Code invalide ou déjà utilisé.');
            return redirect()->to('users/homepage');
        }

        $credited = $this->walletModel->crediter($userId, (float) $code['valeur']);
        $marked = $this->codeModel->marquerUtilise($code['id']);

        if (!$credited || !$marked) {
            session()->setFlashdata('error', 'Impossible d’activer ce code pour le moment.');
            return redirect()->to('users/homepage');
        }

        $db = \Config\Database::connect();
        $db->table('transactions')->insert([
            'user_id' => $userId,
            'code_id' => $code['id'],
            'montant' => (float) $code['valeur'],
            'date_transaction' => date('Y-m-d H:i:s'),
        ]);

        session()->setFlashdata('success', 'Code accepté ! Votre solde a été crédité de ' . number_format((float) $code['valeur'], 2, ',', ' ') . ' €');
        return redirect()->to('users/homepage');
    }

    // -- Mise à jour du profil (Ages, infos, Poids, etc.)
    public function updateProfile()
    {
        $db = \Config\Database::connect();
        $userId = session()->get('id');

        $nom = $this->request->getPost('nom');
        $prenom = $this->request->getPost('prenom');
        $taille = $this->request->getPost('taille');
        $poids = $this->request->getPost('poids');
        $date_naissance = $this->request->getPost('date_naissance');

        // Met à jour la table users
        $db->table('users')->where('id', $userId)->update([
            'nom' => $nom,
            'prenom' => $prenom,
            'date_naissance' => $date_naissance
        ]);

        // Vérifie si on doit insérer ou mettre à jour la santé
        $healthCheck = $db->table('user_health')->where('user_id', $userId)->get();
        if ($healthCheck->getNumRows() > 0) {
            $db->table('user_health')->where('user_id', $userId)->update([
                'taille' => $taille,
                'poids' => $poids,
                'date_mesure' => date('Y-m-d H:i:s')
            ]);
        } else {
            $db->table('user_health')->insert([
                'user_id' => $userId,
                'taille' => $taille,
                'poids' => $poids,
                'date_mesure' => date('Y-m-d H:i:s')
            ]);
        }

        // MAJ de la session si le nom change
        session()->set('username', $nom . ' ' . $prenom);
        
        session()->setFlashdata('success', 'Votre profil a été mis à jour avec succès.');
        return redirect()->to('users/homepage');
    }

    // -- Choix ou mise à jour de l'objectif
    public function updateObjectif()
    {
        $db = \Config\Database::connect();
        $userId = session()->get('id');
        $objId = $this->request->getPost('objectif_id');

        $check = $db->table('user_objectifs')->where('user_id', $userId)->get();
        if ($check->getNumRows() > 0) {
            $db->table('user_objectifs')->where('user_id', $userId)->update(['objectif_id' => $objId]);
        } else {
            $db->table('user_objectifs')->insert(['user_id' => $userId, 'objectif_id' => $objId]);
        }

        session()->setFlashdata('success', 'Votre objectif a été mis à jour.');
        return redirect()->to('users/homepage');
    }
}