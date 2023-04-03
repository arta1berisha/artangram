<?php

namespace App\Traits;

use Illuminate\Http\Response;

trait APIResponseTrait
{
  /**
   * Building success response
   * @param $data
   * @param int $code
   * @return JsonResponse
   */

  public function registerSuccessResponse($user, $token = [])
  {
    return response()->json([
      'status' => 'success',
      'message' => 'User created successfully',
      'user' => $user,
      'authorization' => [
        'token' => $token,
        'type' => 'bearer',
      ]
    ]);
  }

  public function loginErrorResponse()
  {
    return response()->json([
      'status' => 'error',
      'message' => 'Unauthorized',
    ], 401);
  }

  public function loginSuccessResponse($user, $token = [])
  {
    return response()->json([
      'status' => 'success',
      'user' => $user,
      'authorization' => [
        'token' => $token,
        'type' => 'bearer',
      ]
    ]);
  }

  public function deleteUserSuccessResponse()
  {
    return response()->json([
      'status' => true,
      'message' => 'User deleted Successfully',
  ], 204);
  }

  public function deleteUserErrorResponse()
  {
    return response()->json([
      'status' => false,
      'message' => 'Cannot delete User',
  ], 400);
  }
}
