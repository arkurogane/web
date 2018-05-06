<?php

namespace App\Controllers\User;


use App\Controllers\BaseController;
use App\Models\Profesor;

class IndexController extends BaseController
{
    public function getIndex()
    {
        if (isset($_SESSION['userId']))
        {
            $userId=$_SESSION['userId'];
            $docente=Profesor::find($userId);

            if($docente)
            {
                return $this->render('user/index.twig', ['docente'=>$docente]);
            }
        }

        header('Location:' . BASE_URL . 'auth/login');

    }

}