<?php
/**
 * Created by JetBrains PhpStorm.
 * User: daviddjian
 * Date: 28/06/13
 * Time: 22:17
 * To change this template use File | Settings | File Templates.
 */

namespace Core\Controller;

use Zend\I18n\Translator\Translator;
use Zend\ServiceManager\ServiceManager;

/**
 * Class CoreTranslator
 * @package Core\Controller
 */
Trait CoreTranslator
{

    /**
     * @var
     */
    protected $translator;

    /**
     * @param $applicationName
     * @param $locale
     */
    public function setTranslator($applicationName, $locale)
    {
        $lang = $this->getContext()->getParameter('lang');

        if ($lang != 'en_US' && $lang != 'fr_FR') {
            $lang = $locale;
            $this->getContext()->setParameter('lang', $locale);
        }

        if ($this->getSession()->get('language')) {
            $lang = $this->getSession()->get('language');
            $this->getContext()->setParameter('lang', $this->getSession()->get('language'));
        }

        $this->translator = new Translator();
        $this->translator->setLocale($lang);
        $this->translator->addTranslationFile(
            "phparray",
          dirname(__FILE__) . '/../../' . $applicationName . '/Lang/lang.array.' . $lang . '.php'
        );
    }

    /**
     * @return mixed
     */
    public function getTranslator()
    {
        return $this->translator;
    }
}