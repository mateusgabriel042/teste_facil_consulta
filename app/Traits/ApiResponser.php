<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;

trait ApiResponser {
	/**
     * Retorna uma resposta de sucesso.
     *
     * @param mixed $data
     * @param string|null $message
     * @param int $code
     * @return JsonResponse
     */
	protected function success($data, $message = null, $code = 200): JsonResponse
	{
		return response()->json([
			'status' => 'Success',
			'message' => $message,
			'data' => $data
		], $code);
	}

	/**
     * Retorna uma resposta de erro.
     *
     * @param string|null $message
     * @param int $code
     * @param array|null $errors
     * @return JsonResponse
     */
	protected function error($message = null, $code, $errors = null): JsonResponse
	{
		$codes = ['401', '403', '404', '422'];
		if(!in_array($code, $codes)){
			$code = '500';
		}
		return response()->json([
			'status' => 'Error',
			'message' => $message,
			'code' => $code,
			'errors' => $errors,
		], $code);
	}

	/**
     * Verifica as validações da requisição.
     *
     * @param Request $request
     * @return JsonResponse
     */
	protected function verifyValidation($request): JsonResponse
	{
        return $this->error('Erro na requisição!', 422, $request->validator->messages());
	}

	/**
     * Verifica as validações de duas requisições.
     *
     * @param Request $request1
     * @param Request $request2
     * @return JsonResponse
     */
	protected function verifyValidationRecursive($request1, $request2): JsonResponse 
	{
        $errors = array_merge_recursive($request1->validator->messages()->toArray(), $request2->validator->messages()->toArray());
        return $this->error('Erro na requisição!', 422, $errors);
	}

}