<?php

namespace App\controllers;


use App\Models\Profesor;
use App\Models\Admin;
use Sirius\Validation\Validator;

class AuthController extends BaseController
{
    public function getLogin()
    {
        return $this->render('login.twig');

    }

    public function postLogin()
    {
        $validator= new Validator();
        $validator->add('correo','required');
        $validator->add('correo','email');
        $validator->add('password','required');
        if ($validator->validate($_POST))
        {
            $adm =Admin::where('correo',$_POST['correo'])->first();
        if($adm){
                if (password_verify($_POST['password'], $adm->password))
                {
                    $_SESSION['userId']=$adm->id;
                    header('Location:' . BASE_URL . 'admin/index');

                    return null;
                }

            }
            $user = Profesor::where('correo',$_POST['correo'])->first();

            if($user)
            {
                if (password_verify($_POST['password'], $user->password))
                {
                    $_SESSION['userId']=$user->id;
                    header('Location:' . BASE_URL . 'user/index');

                    return null;
                }
            }
            $validator->addMessage('email','Username and/or password does not match');
        }
        $errors=$validator->getMessages();

        return $this->render('login.twig',[
            'errors'=>$errors
            ]);
    }

    public function getLogout()
    {
        unset($_SESSION['userId']);
        header('Location:' . BASE_URL . 'auth/login');
    }

}
