<?php
namespace Jimm\lib;


class FilterData
{
    static public function strip_data($text)
    {
        $quotes = array ("\x27", "\x22", "\x60", "\t", "\n", "\r", "*", "%", "<", ">", "?", "!", "-", "+", "#", "\\");

        $text = trim( strip_tags( $text ) );
        $text = str_replace( $quotes, '', $text );
        $text = htmlspecialchars($text);

        return $text;
    }

}