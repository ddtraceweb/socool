<?php

namespace Cool\HomeBundle\Controller;

use Core\Controller\ActionController;

/**
 * Class HomeController
 * @package Cool\HomeBundle\Controller
 */
class HomeController extends ActionController
{

    /**
     * example controller to call a view.
     */
    public function indexAction()
    {
        $this->render('index.php')->send();
    }
}
