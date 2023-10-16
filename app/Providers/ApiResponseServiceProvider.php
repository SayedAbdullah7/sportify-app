<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Routing\ResponseFactory;

class ApiResponseServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $response = app(ResponseFactory::class);

        $response::macro('success',  function (string $msg ,$data = [],$status=200) use ($response) {
            $responseData = [
                'status' => true,
                'msg' => $msg,
                'data' => $data,
                'errors'=>array(),
            ];
//            return $data;
            return $response->json($responseData, $status);
        });

        $response::macro('error',  function (string $msg,$errors =[], $status =200) use ($response) {
            if (is_string($errors)) {
                $errors_in_format = [$errors];

            }else{
                $errors_in_format = [];
                array_walk_recursive($errors, static function ($error) use (&$errors_in_format) {
                    $errors_in_format[] = $error;
                });
            }

            return $response->json([
                'status' => false,
                'msg' => $msg,
                'data' => array(),
                'errors' => $errors_in_format,
                ], $status);
        });

    }
}
