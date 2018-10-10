<?php
function get_string_between($string, $start, $end){
    $string = ' ' . $string;
    $ini = strpos($string, $start);
    if ($ini == 0) return '';
    $ini += strlen($start);
    $len = strpos($string, $end, $ini) - $ini;
    return substr($string, $ini, $len);
}
function dp_spintax ($str) {
    // Returns random values found between { this | and }
    return preg_replace_callback("/{(.*?)}/", function ($match) {
        // Splits 'foo|bar' strings into an array
        $words = explode("|", $match[1]);
        // Grabs a random array entry and returns it
        return $words[array_rand($words)];
    // The input string, which you provide when calling this func
    }, $str);
}