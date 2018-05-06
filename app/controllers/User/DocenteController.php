<?php

namespace App\Controllers\User;

use App\Controllers\BaseController;
use App\Models\Profesor;
use Sirius\Validation\Validator;
use Illuminate\Support\Facades\DB;

class DocenteController extends BaseController
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

    public function getLista()
    {
        $docente=Profesor::select('id','nombre','correo')->get();
        return $this->render('user/docente.twig',[
            'docente'=>$docente
        ]);
    }

    public function getDatos()
    {
        $userId=$_SESSION['userId'];

        $docente=Profesor::find($userId);

        return $this->render('user/mis_datos.twig', ['docente'=>$docente]);
    }

    public function postDatos()
    {
        $userId=$_SESSION['userId'];

        $docente=Profesor::find($userId);

        $errors=[];
        $result=false;
        $validator=new Validator();
        $validator->add('password','required');
        $validator->add('npassword','required');
        $validator->add('cpassword','required');

        if ($validator->validate($_POST))
        {
            if ($_POST['npassword']==$_POST['cpassword'] && password_verify($_POST['password'], $docente->password)){

                $docente->password=password_hash($_POST['npassword'], PASSWORD_DEFAULT);
                $docente->update();
                $result=true;
            }
        }else{
            $errors=$validator->getMessages();
        }
        
        return $this->render('user/mis_datos.twig', [
            'docente'=>$docente,
            'result'=>$result,
            'errors'=>$errors,
        ]);
    }
}
