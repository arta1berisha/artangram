<?php

namespace App\Traits;

use Illuminate\Http\Response;

trait ApiResponseTrait
{

  /**
   * Building success response
   * @param $data
   * @param int $code
   * @return JsonResponse
   */

 
  public function errorResponse($message = '', $errors = [], $code = '')
  {
    return response()->json([
      'status' => false,
      'message' => $message,
      'errors' => $errors,
      'code' => $code,
    ]);
  }

   public function successResponse($data, $message = '', $code = '')
  {
    return response()->json([
      'status' => true,
      'message' => $message,
      'data' => $data,
      'code' => $code,
    ]);
  }
}
