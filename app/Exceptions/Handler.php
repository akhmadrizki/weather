<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use App\Exceptions\Concerns\ExceptionFormatter;
use Throwable;

class Handler extends ExceptionHandler
{
    use ExceptionFormatter;

    /**
     * A list of exception types with their corresponding custom log levels.
     *
     * @var array<class-string<\Throwable>, \Psr\Log\LogLevel::*>
     */
    protected $levels = [
        //
    ];

    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<\Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    // public function render($request, Throwable $e)
    // {
    //     return parent::render($request, $e);
    // }

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
        return [
            'api/.*',
        ];
    }
}
