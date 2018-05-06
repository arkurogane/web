<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\Admin;
use App\Models\Profesor;
use App\Models\Curso;
use Sirius\Validation\Validator;

class AdminController extends BaseController
{
    public function getInicio()
    {
        if (isset($_SESSION['userId']))
        {
            $userId=$_SESSION['userId'];
            $adm=Admin::find($userId);

            if($adm)
            {
                return $this->render('admin/index.twig', ['adm'=>$adm]);
            }
        }

        header('Location:' . BASE_URL . 'auth/login');

    }
    public function getDatos()
    {
        $userId=$_SESSION['userId'];

        $adm=Admin::find($userId);

        return $this->render('admin/datos.twig', ['adm'=>$adm]);
    }

    public function postDatos()
    {
        $userId=$_SESSION['userId'];

        $adm=Admin::find($userId);

        $errors=[];
        $result=false;
        $validator=new Validator();
        $validator->add('password','required');
        $validator->add('npassword','required');
        $validator->add('cpassword','required');

        if ($validator->validate($_POST))
        {
            if ($_POST['npassword']==$_POST['cpassword'] && password_verify($_POST['password'], $adm->password)){

                $adm->password=password_hash($_POST['npassword'], PASSWORD_DEFAULT);
                $adm->update();
                $result=true;
            }
        }else{
            $errors=$validator->getMessages();
        }

        return $this->render('Admin/datos.twig', [
            'result'=>$result,
            'errors'=>$errors,
        ]);
    }

    public function getRegistro()
    {
        $doc=Profesor::all();
        return $this->render('admin/registro_docentes.twig',[
            'profesor'=>$doc
        ]);
    }

    public function postRegistro()
    {

        $errors=[];
        $result=false;
        $validator=new Validator();
        $validator->add('run','required');
        $validator->add('nombre','required');
        $validator->add('correo','required');
        $validator->add('correo','email');
        $validator->add('imagen','required');
        $validator->add('password','required');
        $validator->add('estado','required');
        $userId=$_SESSION['userId'];

        if ($validator->validate($_POST))
        {
            $profesor=new Profesor();
            $profesor->id=$_POST['run'];
            $profesor->nombre=$_POST['nombre'];
            $profesor->correo=$_POST['correo'];
            $profesor->imagen=$_POST['imagen'];
            $profesor->password=password_hash($_POST['password'], PASSWORD_DEFAULT);
            $profesor->estado_id=$_POST['estado'];
            $profesor->save();
            $result=true;
        }else{
            $errors=$validator->getMessages();
        }
        $doc=Profesor::all();

        return $this->render('admin/registro_docentes.twig',[
            'profesor'=>$doc,
            'result'=>$result,
            'errors'=>$errors
        ]);
    }

    public function getRegistro_curso()
    {
        $curso2=Curso::all();
        return $this->render('admin/registro_cursos.twig',[
            'curso'=>$curso2
        ]);
    }

    public function postRegistro_curso()
    {

        $errors=[];
        $result=false;
        $validator=new Validator();
        $validator->add('nombre','required');

        if ($validator->validate($_POST))
        {
            $curso=new Curso();
            $curso->nombre=$_POST['nombre'];
            $curso->save();
            $result=true;
        }else{
            $errors=$validator->getMessages();
        }
        $curso2=Curso::all();

        return $this->render('admin/registro_cursos.twig',[
            'curso'=>$curso2,
            'result'=>$result,
            'errors'=>$errors
        ]);
    }

    public function postEliminar($id)
    {
        $errors=[];
        $result=false;
        $validator=new Validator();


        $curso = Curso::find($id);
        dd($id);
        $curso->delete();

        $curso2=Curso::all();
        return $this->render('admin/registro_cursos.twig',[
            'curso'=>$curso2,
            'result'=>$result,
            'errors'=>$errors
        ]);
    }
    public function getActividades()
    {
        return $this->render('admin/actividades.twig', []);
    }




}
