<?php

namespace App\Exceptions;

use App\Traits\ApiResponser;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Session\TokenMismatchException;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class Handler extends ExceptionHandler
{
    use ApiResponser;

    protected $dontReport = [
        \Illuminate\Auth\AuthenticationException::class,
        \Illuminate\Auth\Access\AuthorizationException::class,
        \Symfony\Component\HttpKernel\Exception\HttpException::class,
        \Illuminate\Database\Eloquent\ModelNotFoundException::class,
        \Illuminate\Session\TokenMismatchException::class,
        \Illuminate\Validation\ValidationException::class,
    ];

    public function report(Exception $exception){
        parent::report($exception);
    }

    public function render($request, Exception $exception)
    {
        if($exception instanceof ValidationException){
            return $this->convertValidationExceptionToResponse($exception,$request);
        }else if($exception instanceof ModelNotFoundException){
            $modelName = strtolower(class_basename($exception->getModel()));
            return $this->errorResponse("No {$modelName} With specific ID is found",404);
        }else if($exception instanceof AuthenticationException){
            return $this->unauthenticated($request,$exception);
        }
        //if authenticated doesn't have permission/authorized to execute particular action.
        if($exception instanceof AuthorizationException){
            return $this->errorResponse($exception->getMessage(),403);
        }
        if($exception instanceof NotFoundHttpException){
            return $this->errorResponse('The specified URL couldnt be found',403);
        }
        if($exception instanceof MethodNotAllowedHttpException){
            return $this->errorResponse('Specified method isnt allowed',403);
        }
        if($exception instanceof HttpException){
            return $this->errorResponse($exception->getMessage(),$exception->getStatusCode());
        }
        if($exception instanceof QueryException){
            $errorCode = $exception->errorInfo[1];
            return $this->errorResponse("Specified resource is related to other resource conflict code {$errorCode}",409);
        }
        if($exception instanceof TokenMismatchException){
            return redirect()->back()->withInput($request->input());
        }
        if(config('app.debug')){
            return parent::render($request, $exception);
        }
        return $this->errorResponse('Unexpected exception',500);

    }

    protected function unauthenticated($request, AuthenticationException $exception)
    {
        if($this->isFrontend($request)){
            return redirect()->guest('login');
        }
        return $this->errorResponse('Unauthenticated',401);

    }
    protected function convertValidationExceptionToResponse(ValidationException $e, $request)
    {
        $errors = $e->validator->errors()->getMessages();
        if($this->isFrontend($request)){
            return $request->ajax() ? response()->json($errors,422) : redirect()
                ->back()
                ->withInput($request->input())
                ->withErrors($errors);
        }
        return $this->errorResponse($errors, 422);
    }
    protected function isFrontend($request){
        //if it have web middleware and receive html usually from web clients then its front
        return $request->acceptsHtml() && collect($request->route()->middleware())->contains('web');
    }

}
