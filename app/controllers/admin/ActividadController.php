<?php

namespace App\Controllers\Admin;


use App\Controllers\BaseController;
use App\Models\Profesor;
use Sirius\Validation\Validator;

class ActividadController extends BaseController
{
    public function getIndex()
    {
        if (isset($_SESSION['userId']))
        {
            $userId=$_SESSION['userId'];
            $docente=Profesor::find($userId);

            if($docente)
            {
                return $this->render('admin/index.twig', ['docente'=>$docente]);
            }
        }

        header('Location:' . BASE_URL . 'auth/login');

    }

    public function getActividad()
    {
        return $this->render('admin/seleccion_actividad.twig',[]);
    }
}