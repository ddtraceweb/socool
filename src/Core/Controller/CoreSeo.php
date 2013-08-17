<?php
/**
 * Created by JetBrains PhpStorm.
 * User: daviddjian
 * Date: 05/07/13
 * Time: 22:12
 * To change this template use File | Settings | File Templates.
 */

namespace Core\Controller;

Trait CoreSeo{

    protected $seoArray;

    /**
     * @param mixed $seoArray
     */
    public function setSeoArray(array $seoArray)
    {
        $this->seoArray = $seoArray;
    }

    /**
     * @return mixed
     */
    public function getSeoArray()
    {
        return $this->seoArray;
    }

}