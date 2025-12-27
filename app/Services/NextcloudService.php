<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class NextcloudService
{
    // public static function share(string $path): string
    // {
    //     $response = Http::withBasicAuth(
    //         config('services.nextcloud.username'),
    //         config('services.nextcloud.password')
    //     )
    //     ->asForm()
    //     ->post(
    //         config('services.nextcloud.base') . '/ocs/v2.php/apps/files_sharing/api/v1/shares',
    //         [
    //             'path' => "/{$path}",
    //             'shareType' => 3, // public link
    //             'permissions' => 1 // read only
    //         ]
    //     );

    //     return $response->json('ocs.data.url');
    // }
    protected static function client()
    {
        return Http::withBasicAuth(
            config('services.nextcloud.username'),
            config('services.nextcloud.password')
        );
    }

    // public static function makeDir(string $path): void
    // {
    //     self::client()->send(
    //         'MKCOL',
    //         config('services.nextcloud.base') .
    //         config('services.nextcloud.dav') .
    //         "/{$path}"
    //     );
    // }
    public static function makeDir(string $path): void
{
    try {
        self::client()->send(
            'MKCOL',
            config('services.nextcloud.base') .
            config('services.nextcloud.dav') .
            "/{$path}"
        );
    } catch (\Throwable $e) {
        // folder sudah ada → aman
    }
}
public static function shareFolder(string $path): string
{
    $response = Http::withBasicAuth(
        config('services.nextcloud.username'),
        config('services.nextcloud.password')
    )
    ->withHeaders([
        'OCS-APIRequest' => 'true',
        'Accept'         => 'application/json',
    ])
    ->post(
        config('services.nextcloud.base') .
        '/ocs/v2.php/apps/files_sharing/api/v1/shares?format=json',
        [
            'path'        => "/{$path}",
            'shareType'   => 3, // public link
            'permissions' => 1, // read only
        ]
    );

    $data = $response->json();

    $url = data_get($data, 'ocs.data.url');

    if (!$url) {
        Log::error('Nextcloud share folder failed', [
            'path'     => $path,
            'response' => $data,
            'status'   => $response->status(),
        ]);

        throw new \Exception('Failed to create Nextcloud share link');
    }

    return $url;
}




    public static function upload(string $path, string $filename, string $content, string $mime)
    {
        self::client()
            ->withBody($content, $mime)
            ->put(
                config('services.nextcloud.base') .
                config('services.nextcloud.dav') .
                "/{$path}/{$filename}"
            );
    }
}
