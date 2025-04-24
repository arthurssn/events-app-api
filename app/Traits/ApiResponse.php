<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;

trait ApiResponse
{
  /**
   * Retorna uma resposta de sucesso.
   *
   * @param mixed $data Dados a serem retornados.
   * @param string $message Mensagem opcional para a resposta.
   * @param int $status Código de status HTTP (default: 200).
   * @return JsonResponse
   */
  public function success($data, string $message = 'Request successful', int $status = 200): JsonResponse
  {
    return response()->json([
      'success' => true,
      'message' => $message,
      'data' => $data
    ], $status);
  }

  /**
   * Retorna uma resposta de erro.
   *
   * @param string $message Mensagem de erro.
   * @param int $status Código de status HTTP (default: 400).
   * @param mixed $errors Erros adicionais (pode ser um array ou string).
   * @return JsonResponse
   */
  public function error(string $message, int $status = 400, $errors = null): JsonResponse
  {
    return response()->json([
      'success' => false,
      'message' => $message,
      'errors' => $errors
    ], $status);
  }

  /**
   * Retorna uma resposta de validação com erros.
   *
   * @param mixed $errors Erros de validação.
   * @param string $message Mensagem opcional para a resposta.
   * @param int $status Código de status HTTP (default: 422).
   * @return JsonResponse
   */
  public function validationError($errors, string $message = 'Validation failed', int $status = 422): JsonResponse
  {
    return response()->json([
      'success' => false,
      'message' => $message,
      'errors' => $errors
    ], $status);
  }
}
