<?php

namespace App\controllers;

use App\Models\BlogPost;

class IndexController extends BaseController
{
    public function getIndex()
    {

        return $this->render('index.twig');

    }
}
