<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
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

        $this->renderable(function (\Illuminate\Http\Exceptions\PostTooLargeException $e, $request) {
            if ($request->is('admin/prayer-resources*') || $request->is('admin/video-resources*') || $request->is('admin/worship-music*')) {
                return redirect()->back()->with('error', 'The file you are trying to upload is too large. Maximum allowed size is ' . ini_get('post_max_size'));
            }
        });
    }
}
