<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\Profesor;
use App\Models\Alumno;
use App\Models\Curso;
use Sirius\Validation\Validator;

class AcademicoController extends BaseController
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

    public function getRegistro_manual()
    {

        $curso=Curso::all();

        return $this->render('admin/registro_alumno.twig',[
            'curso'=>$curso
        ]);
    }

    public function postRegistro_manual()
    {

        $errors=[];
        $result=false;
        $validator=new Validator();
        $validator->add('curso','required');
        $validator->add('run','required');
        $validator->add('nombre','required');
        $validator->add('imagen','required');
        $userId=$_SESSION['userId'];
        $docente=Profesor::find($userId);

        if ($validator->validate($_POST))
        {
            $alumno=new Alumno();
            $alumno->id=$_POST['run'];
            $alumno->nombre=$_POST['nombre'];
            $alumno->curso_id=$_POST['curso'];
            $alumno->profesor_id=$docente->id;
            $alumno->imagen=$_POST['imagen'];
            $alumno->save();
            $result=true;
        }else{
            $errors=$validator->getMessages();
        }
        $curso=Curso::all();

        return $this->render('admin/registro_alumno.twig',[
            'result'=>$result,
            'errors'=>$errors,
            'curso'=>$curso
        ]);
    }


    public function getLista()
    {
        $userId=$_SESSION['userId'];
            $docente=Profesor::find($userId);
        $alumno=Alumno::all()->where('profesor_id','=',$docente->id);
        return $this->render('admin/seleccion_alumno.twig',[
            'alumno'=>$alumno
        ]);
    }

}
