<?php

namespace App\Juniper\Enum;

use Illuminate\Http\Response;

enum errorCodeEnum
{
    const ValidationError =     ['errorCode' => 1, 'errorMessage' => 'Validation Error', 'statusCode' => Response::HTTP_BAD_REQUEST];
    const NotFoundModel =       ['errorCode' => 2, 'errorMessage' => 'Registry not found', 'statusCode' => Response::HTTP_NOT_FOUND];
    const InternalServerError = ['errorCode' => 3, 'errorMessage' => 'Internal error', 'statusCode' => Response::HTTP_INTERNAL_SERVER_ERROR];
}
