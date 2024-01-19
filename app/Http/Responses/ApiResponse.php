<?php

namespace App\Http\Responses;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Response;
use stdClass;
use Illuminate\Support\Facades\Log;

class ApiResponse
{
    public function responseEnveloper(
        array|Model|Collection $data = [],
        array $errorList = [],
        bool $status = true,
        ?int $errorCode = null,
        string $errorMessage = "Generic Error",
        int $statusCode = Response::HTTP_OK

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
                $response->data  = $data;
                $response->meta = $meta;
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

        return response()->json($response, $statusCode);
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
