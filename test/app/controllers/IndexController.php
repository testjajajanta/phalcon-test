<?php
declare(strict_types=1);
use Phalcon\Mvc\Controller;

class IndexController extends ControllerBase
{

    public function indexAction()
    {
        $this->view->users = Users::find();
    }

}

