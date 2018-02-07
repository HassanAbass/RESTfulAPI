<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Validation\ValidationException;

class TransformInput
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next,$transformer)
    {
        $transformAttributes = [];
        foreach ($request->request as $key => $value){
            $transformAttributes[$transformer::originalAttributes($key)] = $value;
        }
        $request->replace($transformAttributes);
        $response = $next($request);
        if(isset($response->exception) && $response->exception instanceof ValidationException){
            $data = $response->getData();
            $transformedErrors = [];
            foreach ( $data->error  as $key => $value){
                $transformedAttr =  $transformer::transformAttributes($key);
                $transformedErrors[$transformedAttr] = str_replace($key,$transformedAttr,$value);
            }
            $data->error = $transformedErrors;
            $response->setData($data);
        }
        return $response;
    }
}
