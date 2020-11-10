<?php

/*
 *  Text Validation from Forms
 */
class Sanitizer
{


    public function __construct()
    {
    }


    /**
     * Basic parsing of string, using the core built-in functions.
     * @param $str
     * @return string
     */
    public function cleanInput($str)
    {
        $str = trim($str);
        $str = stripslashes($str);
        $str = htmlspecialchars($str);
        return $str;
    }
}


