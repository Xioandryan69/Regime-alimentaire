<?php 

namespace App\Controllers;

Class AdminListUsers extends BaseController
{
    public function listUsers()
    {
        $userModel = new \App\Models\UserModel();
        $data['users'] = $userModel->where('role', 'user')->orderBy('nom', 'ASC')->findAll();
        return view('admin/listUsers', $data);
    }

    public function affProfil($id)
    {
        $db = \Config\Database::connect();

        $userNameQuery = "SELECT nom FROM users WHERE id = " . $id;
        $userName = $db->query($userNameQuery)->getRow()->nom ?? 'Utilisateur';

        $userLastNameQuery = "SELECT prenom FROM users WHERE id = " . $id;
        $userLastName = $db->query($userLastNameQuery)->getRow()->prenom ?? '';

        $userMailQuery = "SELECT email FROM users WHERE id = " . $id;
        $userMail = $db->query($userMailQuery)->getRow()->email ?? '';

        $userdateNaissanceQuery = "SELECT date_naissance FROM users WHERE id = " . $id;
        $dateNaissance = $db->query($userdateNaissanceQuery)->getRow()->date_naissance ?? '';
        $dateNaissance2 = new \DateTime($dateNaissance);
        $currentDate = new \DateTime();
        $userAge = $dateNaissance2->diff($currentDate)->y;

        $userTailleQuery = "SELECT taille FROM user_health WHERE user_id = " . $id;
        $userTaille = $db->query($userTailleQuery)->getRow()->taille ?? '';

        $userPoidsQuery = "SELECT poids FROM user_health WHERE user_id = " . $id;
        $userPoids = $db->query($userPoidsQuery)->getRow()->poids ?? 0;

        $userTailleMeters = (float)$userTaille;
        $userImc = ($userTailleMeters > 0) ? ($userPoids / ($userTailleMeters * $userTailleMeters)) : 0;

        $getObjectifId = "SELECT objectif_id FROM user_objectifs WHERE user_id = " . $id;
        $objectifRow = $db->query($getObjectifId)->getRow();
        $objectifId = $objectifRow ? $objectifRow->objectif_id : 0; 
        $userObjectif = '';
        if ($objectifId > 0) {
            $userObjectifQuerry = "SELECT nom FROM objectifs WHERE id = " . $objectifId;
            $userObjectif = $db->query($userObjectifQuerry)->getRow()->nom ?? '';
        }

        $dataU = [
            'userName'        => $userName,
            'userLastName'    => $userLastName,
            'userMail'         => $userMail,
            'userAge'          => $userAge,
            'userTaille'       => $userTaille,
            'userPoids'        => $userPoids,
            'userImc'       => round($userImc, 2),
            'userObjectif' => $userObjectif,
            'dateNaissance' => $dateNaissance
        ];
        return view('admin/profilUser', $dataU);
    }
}
