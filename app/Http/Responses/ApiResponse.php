<?php

namespace App\Http\Responses;

use stdClass;

class ApiResponse
{
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
