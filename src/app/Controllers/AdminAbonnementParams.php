<?php

namespace App\Controllers;

use App\Models\AbonnementParamModel;

class AdminAbonnementParams extends BaseController
{
    protected $abonnementParamModel;

    public function __construct()
    {
        $this->abonnementParamModel = new AbonnementParamModel();
    }

    public function index()
    {
        $plans = [];
        if ($this->abonnementParamModel->db->tableExists($this->abonnementParamModel->table)) {
            $plans = $this->abonnementParamModel->findAll();
        } else {
            session()->setFlashdata('error', 'La table abonnement_params est introuvable. Créez-la avant d’utiliser cette fonctionnalité.');
        }

        return view('admin/abonnements/index', ['plans' => $plans]);
    }

    public function create()
    {
        if (! $this->abonnementParamModel->db->tableExists($this->abonnementParamModel->table)) {
            session()->setFlashdata('error', 'La table abonnement_params est introuvable. Créez-la avant d’utiliser cette fonctionnalité.');
            return redirect()->to('admin/abonnements');
        }

        return view('admin/abonnements/create');
    }

    public function store()
    {
        if (! $this->abonnementParamModel->db->tableExists($this->abonnementParamModel->table)) {
            session()->setFlashdata('error', 'La table abonnement_params est introuvable. Créez-la avant d’utiliser cette fonctionnalité.');
            return redirect()->to('admin/abonnements');
        }

        $this->abonnementParamModel->save([
            'code' => strtoupper($this->request->getPost('code')),
            'nom' => $this->request->getPost('nom'),
            'description' => $this->request->getPost('description'),
            'prix' => $this->request->getPost('prix'),
            'remise' => $this->request->getPost('remise'),
            'duree_jours' => $this->request->getPost('duree_jours'),
            'actif' => $this->request->getPost('actif') ? 1 : 0,
        ]);

        session()->setFlashdata('success', 'Type d’abonnement enregistré avec succès.');
        return redirect()->to('admin/abonnements');
    }

    public function edit($id)
    {
        if (! $this->abonnementParamModel->db->tableExists($this->abonnementParamModel->table)) {
            session()->setFlashdata('error', 'La table abonnement_params est introuvable. Créez-la avant d’utiliser cette fonctionnalité.');
            return redirect()->to('admin/abonnements');
        }

        $plan = $this->abonnementParamModel->find($id);

        if (empty($plan)) {
            session()->setFlashdata('error', 'Paramètre d’abonnement introuvable.');
            return redirect()->to('admin/abonnements');
        }

        return view('admin/abonnements/edit', ['plan' => $plan]);
    }

    public function update($id)
    {
        if (! $this->abonnementParamModel->db->tableExists($this->abonnementParamModel->table)) {
            session()->setFlashdata('error', 'La table abonnement_params est introuvable. Créez-la avant d’utiliser cette fonctionnalité.');
            return redirect()->to('admin/abonnements');
        }

        $this->abonnementParamModel->update($id, [
            'code' => strtoupper($this->request->getPost('code')),
            'nom' => $this->request->getPost('nom'),
            'description' => $this->request->getPost('description'),
            'prix' => $this->request->getPost('prix'),
            'remise' => $this->request->getPost('remise'),
            'duree_jours' => $this->request->getPost('duree_jours'),
            'actif' => $this->request->getPost('actif') ? 1 : 0,
        ]);

        session()->setFlashdata('success', 'Paramètre d’abonnement mis à jour.');
        return redirect()->to('admin/abonnements');
    }

    public function delete($id)
    {
        if (! $this->abonnementParamModel->db->tableExists($this->abonnementParamModel->table)) {
            session()->setFlashdata('error', 'La table abonnement_params est introuvable. Créez-la avant d’utiliser cette fonctionnalité.');
            return redirect()->to('admin/abonnements');
        }

        $this->abonnementParamModel->delete($id);
        session()->setFlashdata('success', 'Type d’abonnement supprimé.');
        return redirect()->to('admin/abonnements');
    }
}
