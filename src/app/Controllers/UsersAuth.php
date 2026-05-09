<?php

namespace App\Controllers;

class UsersAuth extends BaseController
{
    public function login()
    {
        if (session()->get('isUsersLoggedIn')) {
            return redirect()->to('/users/homepage'); 
        }

        return view('users/login');
    }

    public function loginCheck()
    {
        $session = session();
        
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        $userModel = new \App\Models\UserModel();
        $users = $userModel->where('email', $username)
                           ->where('role', 'user')
                           ->first();

        // On vérifie avec password_verify car le mot de passe est haché dans la BDD (password)
        if ($users && password_verify($password, $users['password'])) {
            
            $ses_data = [
                'id'              => $users['id'],
                'username'        => $users['nom'] . ' ' . $users['prenom'],
                'email'           => $users['email'],
                'isUsersLoggedIn' => true
            ];
            $session->set($ses_data);
            
            return redirect()->to('/users/homepage');

        } else {
            $session->setFlashdata('error', 'Email ou mot de passe incorrect, ou accès non autorisé.');
            return redirect()->to('/users/login');
        }
    }

    public function logout()
    {
        $session = session();
        $session->destroy();
        
        return redirect()->to('/users/login');
    }
}