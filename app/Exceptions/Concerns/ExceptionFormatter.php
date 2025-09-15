<?php

namespace App\Exceptions\Concerns;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Throwable;

trait ExceptionFormatter
{
    /**
     * Convert an authentication exception into a JSON response.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Illuminate\Auth\AuthenticationException $exception
     * @return \Illuminate\Http\JsonResponse
     */
    protected function unauthenticated($request, AuthenticationException $exception): JsonResponse
    {
        if (! $this->shouldCustomFormat($request)) {
            // Get parent response
            $response = parent::unauthenticated($request, $exception);

            // Safely get content with type check
            $content = $response->getContent();
            $jsonContent = is_string($content) ? $content : '{}';

            // Create JsonResponse with proper type handling
            return JsonResponse::fromJsonString($jsonContent, $response->getStatusCode(), $response->headers->all());
        }

        $title = $this->mapErrorTitle(Response::HTTP_UNAUTHORIZED);

        return response()->json([
            'error' => [
                'code'    => Response::HTTP_UNAUTHORIZED,
                'title'   => $title,
                'message' => $exception->getMessage(),
                'errors'  => [],
            ],
        ], Response::HTTP_UNAUTHORIZED);
    }

    /**
     * Convert a validation exception into a JSON response.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    protected function invalidJson($request, ValidationException $exception): JsonResponse
    {
        if (! $this->shouldCustomFormat($request)) {
            return parent::invalidJson($request, $exception);
        }

        $errors = [];

        foreach ($exception->errors() as $key => $message) {
            $errorMessage = is_array($message) && !empty($message) ? $message[0] : 'Validation error';

            $errors[] = [
                'key'     => $key,
                'message' => $errorMessage,
            ];
        }

        return response()->json([
            'error' => [
                'code'    => (int) $exception->status,
                'title'   => $this->mapErrorTitle($exception->status),
                'message' => $exception->getMessage(),
                'errors'  => $errors,
            ],
        ], $exception->status);
    }

    /**
     * Prepare a JSON response for the given exception.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Throwable|\Exception|\Symfony\Component\HttpKernel\Exception\HttpExceptionInterface  $e
     * @return \Illuminate\Http\JsonResponse
     */
    protected function prepareJsonResponse($request, Throwable $e): JsonResponse
    {
        if (! $this->shouldCustomFormat($request)) {
            return parent::prepareJsonResponse($request, $e);
        }

        $status = Response::HTTP_INTERNAL_SERVER_ERROR;

        if ($e instanceof HttpExceptionInterface) {
            $status = $e->getStatusCode();
        }

        $errorsArray = [
            'error' => [
                'code'    => $status,
                'title'   => $this->mapErrorTitle($status),
                'message' => $this->generateErrorMessage($e),
                'errors'  => [],
            ],
        ];

        if (config('app.debug')) {
            $errorsArray = array_merge($errorsArray, $this->convertExceptionToArray($e));
        }

        return new JsonResponse(
            $errorsArray,
            $status,
            $e instanceof HttpExceptionInterface ? $e->getHeaders() : [],
            JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES
        );
    }

    /**
     * Map Error Exception Title
     *
     * @return string
     */
    protected function mapErrorTitle(int $status): string
    {
        switch ($status) {
            case Response::HTTP_BAD_REQUEST:
                return 'Bad Request';

            case Response::HTTP_NOT_FOUND:
                return 'Not Found';

            case Response::HTTP_FORBIDDEN:
                return 'Access Forbidden';

            case Response::HTTP_METHOD_NOT_ALLOWED:
                return 'Request Method Not Allow';

            case Response::HTTP_REQUEST_TIMEOUT:
                return 'Request Timeout';

            case Response::HTTP_TOO_MANY_REQUESTS:
                return 'Too Many Request';

            case Response::HTTP_UNPROCESSABLE_ENTITY:
                return 'Validation Error';

            case Response::HTTP_UNAUTHORIZED:
                return 'Authentication Failed';

            default:
                return 'Server Error';
        }
    }

    /**
     * Generate error message for response
     */
    protected function generateErrorMessage(Throwable $e): string
    {
        $previousException = $e->getPrevious();

        if ($previousException instanceof ModelNotFoundException) {
            return $this->modelNotFoundMessage($previousException);
        }

        return $e instanceof HttpExceptionInterface ? $e->getMessage() : 'Server Error';
    }

    /**
     * Format a ModelNotFoundException into a user-friendly error message
     *
     * @template TModel of \Illuminate\Database\Eloquent\Model
     * @param \Illuminate\Database\Eloquent\ModelNotFoundException<TModel> $exception
     * @return string
     */
    protected function modelNotFoundMessage(ModelNotFoundException $exception): string
    {
        $model = $exception->getModel();

        if (empty($model)) {
            return 'Requested resource was not found.';
        }

        $modelName = $this->getModelName($model);

        return "Sorry, the {$modelName} is not found.";
    }

    /**
     * Extract the model name from a fully qualified class name
     *
     * @param string $modelClass
     * @return string
     */
    private function getModelName(string $modelClass): string
    {
        // Get the class name without namespace
        $className = class_basename($modelClass);

        // Convert to snake case and replace underscores with spaces
        return Str::lower(Str::snake($className, ' '));
    }

    /**
     * Determine if response need to use Timedoor format
     *
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
    protected function shouldCustomFormat($request): bool
    {
        foreach ($this->urlPathPattern() as $pattern) {
            if (preg_match('#^' . $pattern . '\z#u', $request->decodedPath()) === 1) {
                return true;
            }
        }

        return false;
    }

    /**
     * List of url path that use custom Exception Format. You can use Regex in the list
     *
     * @return array<string>
     *
     * @example return [
     *  'api/v[1-9]+/.*'
     * ];
     */
    protected function urlPathPattern(): array
    {
        return [];
    }

    /**
     * Determine if the exception handler response should be JSON.
     *
     * @param  \Illuminate\Http\Request $request
     * @return bool
     */
    protected function shouldReturnJson($request, Throwable $e): bool
    {
        return $request->expectsJson() || $this->shouldCustomFormat($request);
    }
}
