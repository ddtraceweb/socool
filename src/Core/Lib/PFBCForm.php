<?php
/**
 * Created by JetBrains PhpStorm.
 * User: daviddjian
 * Date: 03/07/13
 * Time: 13:57
 * To change this template use File | Settings | File Templates.
 */

namespace Core\Lib;

use PFBC\Form;

class PFBCForm extends Form
{

    public function __construct($id)
    {
        parent::__construct($id);
    }
}