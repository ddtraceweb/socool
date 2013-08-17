<?php
/**
 * Created by JetBrains PhpStorm.
 * User: daviddjian
 * Date: 04/11/12
 * Time: 03:03
 * To change this template use File | Settings | File Templates.
 */

namespace Core\Lib;

class Slugger
{

    private $wordSeparator;
    private $fieldSeparator;

    public function __construct($wordSeparator, $fieldSeparator)
    {
        $this->wordSeparator  = $wordSeparator;
        $this->fieldSeparator = $fieldSeparator;
    }

    /**
     * Return a slug, ensuring it does not appear in exclude (prior collisions)
     *
     * @param       $fields
     * @param array $exclude list of slugs to exclude
     *
     * @return void
     * Reference: Doctrine 1_4 slugify
     */
    public function getSlug($fields, $exclude = array())
    {
        // Determine if we are dealing with single-field or multiple-field slugs
        if (!is_array($fields)) {
            $fields = array($fields);
        }

        foreach ($fields as &$field) {
            // Add special treatment for 's i.e. "Sam's" becomes "Sams"
            $field = preg_replace('~\'s(\s|\z)~', 's$1', $field);

            // Treat the data (eliminate non-letter or digits by '-'
            $field = preg_replace('~[^\\pL\d]+~u', $this->wordSeparator, $field);

            // Clean up the slug
            $field = trim($field, $this->wordSeparator);

            // Translate
            if (function_exists('iconv')) {
                $field = iconv('utf-8', 'us-ascii//TRANSLIT', $field);
            }

            // Lowercase
            $field = strtolower($field);

            // Remove unwanted characters
            $field = preg_replace('~[^-\w]+~', '', $field);
        }

        $slug = implode($this->fieldSeparator, $fields);

        // Fall-back to produce something
        if (!trim($slug)) {
            $slug = 'n-a';
        }

        // Append an index to the slug and see if we can generate a unique value
        $loop = 1;
        $test = $slug;
        while (in_array($test, $exclude)) {
            $test = $slug . ('-' . $loop++);
        }
        $slug = $test;

        // We have our unique slug suggestion
        return $slug;
    }
}