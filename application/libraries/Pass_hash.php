<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Pass_hash {  
  
    // blowfish
    // '$2a' indicates that we will be using the BLOWFISH algorithm  
    private static $algo = '$2a';  
  
    // cost parameter
    // '$10' is the "cost parameter". This is the base-2 logarithm of how many iterations it will run 
    // (10 => 2^10 = 1024 iterations.) This number can range between 04 and 31.   
    private static $cost = '$10';  
  
    // mainly for internal use  
    public static function unique_salt() {  
        return substr(sha1(mt_rand()),0,22);  
    }  
  
    // this will be used to generate a hash  
    public static function hash($password) {  
  
        return crypt($password,  
                    self::$algo .  
                    self::$cost .  
                    '$' . self::unique_salt());  
  
    }  
  
    // this will be used to compare a password against a hash  
    public static function check_password($hash, $password) {  
  
        $full_salt = substr($hash, 0, 29);  
  
        $new_hash = crypt($password, $full_salt);  
  
        return ($hash == $new_hash);  
  
    }  
  
}