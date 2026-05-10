<?php

namespace App\Controllers;

use App\Models\ObjectifModel;
use App\Models\RecommendationModel;
use App\Models\UserHealthModel;
use App\Models\UserObjectifModel;

class UsersHomepage extends BaseController
{
    public function imc()
    {
        $userId = (int) session()->get('id');
        $userHealthModel = new UserHealthModel();

        $sante = $userHealthModel->getParUser($userId);
        $imc = 0;
        $categorie = null;

        if ($sante && isset($sante['imc']) && $sante['imc'] !== null) {
            $imc = (float) $sante['imc'];
            $categorie = $userHealthModel->categorieIMC($imc);
        }

        return view('users/imc/index', [
            'sante' => $sante,
            'imc' => round($imc, 2),
            'categorie' => $categorie,
        ]);
    }

    public function index()
    {
        $db = \Config\Database::connect();
        $objectifModel = new ObjectifModel();
        $userObjectifModel = new UserObjectifModel();
        $userId = (int) session()->get('id');
        
        $userNameQuery = "SELECT nom FROM users WHERE id = " . $userId;
        $userName = $db->query($userNameQuery)->getRow()->nom ?? 'Utilisateur';

        $userLastNameQuery = "SELECT prenom FROM users WHERE id = " . $userId;
        $userLastName = $db->query($userLastNameQuery)->getRow()->prenom ?? '';

        $userMailQuery = "SELECT email FROM users WHERE id = " . $userId;
        $userMail = $db->query($userMailQuery)->getRow()->email ?? '';

        $userdateNaissanceQuery = "SELECT date_naissance FROM users WHERE id = " . $userId;
        $dateNaissance = $db->query($userdateNaissanceQuery)->getRow()->date_naissance ?? '';
        $dateNaissance2 = new \DateTime($dateNaissance);
        $currentDate = new \DateTime();
        $userAge = $dateNaissance2->diff($currentDate)->y;

        $userTailleQuery = "SELECT taille FROM user_health WHERE user_id = " . $userId;
        $userTaille = $db->query($userTailleQuery)->getRow()->taille ?? '';

        $userPoidsQuery = "SELECT poids FROM user_health WHERE user_id = " . $userId;
        $userPoids = $db->query($userPoidsQuery)->getRow()->poids ?? 0;

        $userTailleMeters = (float)$userTaille;
        $userImc = ($userTailleMeters > 0) ? ($userPoids / ($userTailleMeters * $userTailleMeters)) : 0;

        $objectifs = $objectifModel->findAll();
        $userObjectifRow = $userObjectifModel->where('user_id', $userId)->first();
        $objectifId = $userObjectifRow ? (int) $userObjectifRow['objectif_id'] : 0;
        $objectifActuel = $objectifId > 0 ? $objectifModel->find($objectifId) : null;
        $userObjectif = $objectifActuel['nom'] ?? '';

        // Récupération des régimes et activités (recommandations suivies)
        $userActivitesRegimesQuery = "
            SELECT r.nom as regime_nom, a.nom as activite_nom, rec.date_debut, rec.date_fin 
            FROM recommendations rec
            LEFT JOIN regimes r ON rec.regime_id = r.id
            LEFT JOIN activites a ON rec.activite_id = a.id
            WHERE rec.user_id = " . $userId . "
            ORDER BY rec.date_debut DESC";
        $userProgrammes = $db->query($userActivitesRegimesQuery)->getResultArray();

        $data = [
            'userName'        => $userName,
            'userLastName'    => $userLastName,
            'userMail'         => $userMail,
            'userAge'          => $userAge,
            'userTaille'       => $userTaille,
            'userPoids'        => $userPoids,
            'userImc'       => round($userImc, 2),
            'userObjectif' => $userObjectif,
            'currentObjectifId' => $objectifId,
            'objectifs' => $objectifs,
            'userProgrammes' => $userProgrammes,
            'dateNaissance' => $dateNaissance
        ];

        return view('users/homepage', $data);
    }

    // -- Mise à jour du profil (Ages, infos, Poids, etc.)
    public function updateProfile()
    {
        $db = \Config\Database::connect();
        $userId = session()->get('id');
        $userHealthModel = new UserHealthModel();

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

        // Sauvegarde santé via le modèle (IMC recalculé automatiquement)
        $userHealthModel->sauvegarder((int) $userId, [
            'taille' => (float) $taille,
            'poids' => (float) $poids,
            'date_mesure' => date('Y-m-d H:i:s'),
        ]);

        // MAJ de la session si le nom change
        session()->set('username', $nom . ' ' . $prenom);
        
        session()->setFlashdata('success', 'Votre profil a été mis à jour avec succès.');
        return redirect()->to('users/homepage');
    }

    // -- Choix ou mise à jour de l'objectif
    public function updateObjectif()
    {
        $userId = (int) session()->get('id');
        $objId = (int) $this->request->getPost('objectif_id');
        $objectifModel = new ObjectifModel();
        $userObjectifModel = new UserObjectifModel();

        if ($userId <= 0) {
            session()->setFlashdata('error', 'Session utilisateur invalide.');
            return redirect()->to('users/login');
        }

        if ($objId <= 0 || !$objectifModel->find($objId)) {
            session()->setFlashdata('error', 'Objectif invalide.');
            return redirect()->to('users/homepage');
        }

        if (!$userObjectifModel->sauvegarder($userId, $objId)) {
            session()->setFlashdata('error', 'Impossible de mettre à jour votre objectif.');
            return redirect()->to('users/homepage');
        }

        session()->setFlashdata('success', 'Votre objectif a été mis à jour.');
        return redirect()->to('users/homepage');
    }

    public function recommendations()
    {
        $userId = (int) session()->get('id');
        $recommendationModel = new RecommendationModel();

        $preview = $recommendationModel->getSuggestionPreview($userId);
        $savedRecommendations = $recommendationModel->getAvecDetails($userId);

        return view('users/recommendations/index', array_merge($preview, [
            'savedRecommendations' => $savedRecommendations,
        ]));
    }

    public function generateRecommendations()
    {
        $userId = (int) session()->get('id');
        $recommendationModel = new RecommendationModel();
        $result = $recommendationModel->genererPourUtilisateur($userId);

        session()->setFlashdata(
            !empty($result['success']) ? 'success' : 'error',
            $result['message'] ?? 'Impossible de générer les recommandations.'
        );

        return redirect()->to('users/recommendations');
    }

    public function recommendedActivities()
    {
        $userId = (int) session()->get('id');
        $recommendationModel = new RecommendationModel();

        $context = $recommendationModel->getSuggestionContext($userId);
        $activitiesTable = $recommendationModel->getRecommendedActivitiesTable($userId);

        return view('users/recommendations/activities', [
            'context' => $context,
            'activitiesTable' => $activitiesTable,
        ]);
    }
}