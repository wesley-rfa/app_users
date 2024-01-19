<?php

namespace App\Http\Responses;

use stdClass;
use Illuminate\Support\Facades\Log;

class ApiResponse
{
    public function responseEnveloper(
        array $data = [],
        array $errorList = [],
        bool $status = true,
        ?int $errorCode = null,
        string $errorMessage = "Generic Error"

    ) {
        $data       = $data ?? null;
        $errorList  = $errorList ?? null;

        $response           = new stdClass;
        $meta               = new stdClass;
        $error              = new stdClass;

        if ($status) {
            $response->success = $status;
            if ($data) {
                $meta->apiVersion = env("API_VERSION");
                $response->meta = $meta;
                $response->data  = $data;
            }
        } else {
            $error->errorCode = $errorCode;
            $error->errorMessage = $errorMessage;
            $error->errorList = $errorList;

            $meta->apiVersion = env("API_VERSION");

            $response->success = $status;
            $response->data = $error;
            $response->meta = $meta;
        }

        return json_encode($response);
    }

    public function responseErrorEnveloper($request, $errorCodeEnum, array $errors = [])
    {
        $response = new stdClass;
        $response->success = false;

        foreach ($errors as $key => $error) {
            unset($errors[$key]);
            $errors[$this->snakeCaseToCamelCase($key)] = $error;
        }

        $data = new stdClass;

        $data->errorCode = $errorCodeEnum['errorCode'];
        $data->errorMessage = $errorCodeEnum['errorMessage'];
        $data->errorList = $errors;


        $response->data = $data;

        $meta = new stdClass;
        $meta->apiVersion = env("API_VERSION");

        $response->meta = $meta;

        Log::channel('app')->warning(
            $errorCodeEnum['errorMessage'],
            [
                'url' => $request->url(),
                'method' => $request->method(),
                'request' => $request->all(),
                'errorList' => $data->errorList
            ]
        );

        return response()->json($response, $errorCodeEnum['statusCode']);
    }

    private function snakeCaseToCamelCase($string, $noStrip = [])
    {
        $string = preg_replace('/[^a-z0-9' . implode("", $noStrip) . ']+/i', ' ', $string);
        $string = trim($string);

        $string = ucwords($string);
        $string = str_replace(" ", "", $string);
        $string = lcfirst($string);

        return $string;
    }
}
