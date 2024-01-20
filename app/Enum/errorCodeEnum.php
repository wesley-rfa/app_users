<?php

namespace App\Enum;

use Illuminate\Http\Response;

enum errorCodeEnum
{
    const ValidationError =     ['errorCode' => 1, 'errorMessage' => 'Ajuste o preenchimento dos campos', 'statusCode' => Response::HTTP_BAD_REQUEST];
    const NotFoundModel =       ['errorCode' => 2, 'errorMessage' => 'Registro não encontrado', 'statusCode' => Response::HTTP_NOT_FOUND];
    const InternalServerError = ['errorCode' => 3, 'errorMessage' => 'Erro interno', 'statusCode' => Response::HTTP_INTERNAL_SERVER_ERROR];
}
