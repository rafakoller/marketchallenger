<?php

/**
 * Cript hashing class
 * @author Rafael Koller <rafakoller@gmail.com>
 */
class Cript {

    /**
     * Hash a string
     * @param  string  $string The string
     * @return string
     */
    public static function hash($string) {

        $opt = ['cost' => 8];
        $hashString = password_hash($string, PASSWORD_BCRYPT, $opt);
        return $hashString;
    }

    /**
     * Check a hashed string
     * @param  string $string The string
     * @param  string $hash   The hash
     * @return boolean
     */
    public static function check($string, $hash) {
        return (password_verify($string, $hash));
    }

}