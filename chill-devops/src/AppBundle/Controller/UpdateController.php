<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class UpdateController extends Controller
{
    public function UpdateAction($name)
    {
        return $this->render('', array('name' => $name));
    }
}
