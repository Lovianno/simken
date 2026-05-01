<?php

namespace App\Exceptions;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;
use Illuminate\Support\Facades\Log;

class Handler extends ExceptionHandler
{
  public function render($request, Throwable $e)
  {
      Log::error('Exception caught', [
          'error' => $e->getMessage(),
          'trace' => $e->getTraceAsString(),
          'url' => $request->fullUrl(),
          'input' => $request->all(),
      ]);

      // Gunakan wantsJson untuk akurat, dan cek hanya API route
      if ($request->is('api/*') || $request->wantsJson()) {
          return $this->renderJson($e);
      }

      return parent::render($request, $e);
  }

  protected function renderJson(Throwable $e)
  {
    if ($e instanceof ValidationException) {
      return response()->json([
        'success' => false,
        'message' => 'Validasi gagal.',
        'errors'  => $e->errors(),
      ], 422);
    }

    if ($e instanceof AuthorizationException) {
      return $this->jsonError('Tidak diizinkan.', 403);
    }

    if ($e instanceof AuthenticationException) {
      return $this->jsonError('Belum login.', 401);
    }

    if ($e instanceof ModelNotFoundException) {
      return $this->jsonError('Data tidak ditemukan.', 404);
    }

    if ($e instanceof NotFoundHttpException) {
      return $this->jsonError('Endpoint tidak ditemukan.', 404);
    }

    if ($e instanceof HttpException) {
      return $this->jsonError($e->getMessage() ?: 'HTTP error.', $e->getStatusCode());
    }

    return $this->handleUnexpectedJson($e);
  }

  protected function jsonError(string $message, int $status)
  {
    return response()->json([
      'success' => false,
      'message' => $message,
    ], $status);
  }

  protected function handleUnexpectedJson(Throwable $e)
  {
    Log::error("Unexpected JSON Exception", [
      'error' => $e->getMessage(),
      'trace' => $e->getTraceAsString(),
    ]);

    return $this->jsonError('Server error.', 500);
  }
}
