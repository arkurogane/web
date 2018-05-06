<?php

namespace App\controllers;


class IndexController extends BaseController
{
    public function getIndex()
    {

        return $this->render('index.twig');

    }
}
