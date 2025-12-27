<?php
namespace App\Services;

class FileCryptoService
{
    public static function encrypt(string $content): string
    {
        $key = base64_decode(config('app.attachment_encrypt_key'));
        $iv  = random_bytes(16);

        $encrypted = openssl_encrypt(
            $content,
            'AES-256-CBC',
            $key,
            OPENSSL_RAW_DATA,
            $iv
        );
        return base64_encode($iv . $encrypted);
    }
}
