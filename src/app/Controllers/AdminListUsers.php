<?php 

namespace App\Controllers;

Class AdminListUsers extends BaseController
{
    public function listUsers()
    {
        return view('admin/listUsers');
    }
}
