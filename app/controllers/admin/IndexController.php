<?php

namespace App\Controllers\Admin;


use App\Controllers\BaseController;
use App\Models\Admin;

class IndexController extends BaseController
{
    public function getIndex()
    {
        if (isset($_SESSION['userId']))
        {
            $userId=$_SESSION['userId'];
            $adm=Admin::find($userId);

            if($adm)
            {
                return $this->render('admin/Index.twig', ['adm'=>$adm]);
            }
        }

        header('Location:' . BASE_URL . 'auth/login');

    }

}