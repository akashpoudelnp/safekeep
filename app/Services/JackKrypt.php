<?php

namespace App\Services;

use Exception;
use Illuminate\Support\Facades\Hash;

class JackKrypt{
    /**
     * Encrypts (but does not authenticate) a message
     *
     * @param string $message - plaintext message
     * @param string $key - encryption key (raw binary expected)
     * @param boolean $encode - set to TRUE to return a base64-encoded
     * @return string (raw binary)
     */
    public static function encrypt($message, $key, $encode = false)
    {
        $method = "aes128";
        $nonceSize = openssl_cipher_iv_length($method);
        $nonce = openssl_random_pseudo_bytes($nonceSize);

        $ciphertext = openssl_encrypt(
            $message,
           $method,
            $key,
            OPENSSL_RAW_DATA,
            $nonce
        );

        // Now let's pack the IV and the ciphertext together
        // Naively, we can just concatenate
        if ($encode) {
            return base64_encode($nonce.$ciphertext);
        }
        return $nonce.$ciphertext;
    }
/**
     * Decrypts (but does not verify) a message
     *
     * @param string $message - ciphertext message
     * @param string $key - encryption key (raw binary expected)
     * @param boolean $encoded - are we expecting an encoded string?
     * @return string
     */

    public static function decrypt($message, $key, $encoded = false)
    {
        $method = "aes128";
        if ($encoded) {
            $message = base64_decode($message, true);
            if ($message === false) {
                throw new Exception('Encryption failure');
            }
        }

        $nonceSize = openssl_cipher_iv_length($method);
        $nonce = mb_substr($message, 0, $nonceSize, '8bit');
        $ciphertext = mb_substr($message, $nonceSize, null, '8bit');

        $plaintext = openssl_decrypt(
            $ciphertext,
            $method,
            $key,
            OPENSSL_RAW_DATA,
            $nonce
        );

        return $plaintext;
    }

    /**
     * Checks the integrity of the stored data
     *
     * @param string $title - phrase's title
     * @param string $en_phrase - encrypted phrase key
     * @param string $hash - hash value of title and phrase during initial data insertion
     * @param string $key - your secret key used to encrypt data
     * @return boolean
     */
    public static function CheckHash($title,$en_phrase,$hash,$key)
    {
            $de_phrase= JackKrypt::decrypt($en_phrase,$key);
            $pre_hash= $title.$de_phrase;

            if(Hash::check($pre_hash,$hash))
            {
                return true;
            }
            else{
                return false;
            }
    }





}
