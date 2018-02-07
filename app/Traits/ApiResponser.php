<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

trait ApiResponser {

    private function successResponse($data,$code){
        return response()->json($data,$code);
    }
    private function transformData($data, $transformer){
        $transformation = fractal($data, new $transformer);
        return $transformation->toArray();
    }
    private function sortData(Collection $collection,$transformer){
        if(request()->has('sort_by')){
            $attribute = $transformer::originalAttributes(request()->sort_by);
            $collection = $collection->sortBy->{$attribute};
        }
        return $collection;
    }
    private function paginate(Collection $collection){
        $page = LengthAwarePaginator::resolveCurrentPage();
        $perPage = 15;
        $results = $collection->slice(($page-1)*$perPage,$perPage)->values();
        $paginated = new LengthAwarePaginator($results, $collection->count(),$perPage,$page,[
           'path'   => LengthAwarePaginator::resolveCurrentPath(),
        ]);
        $paginated->appends(request()->all());
        return $paginated;
    }
    private function filterData(Collection $collection,$transformer){
        foreach (request()->query() as $query => $value){
            $attribute = $transformer::originalAttributes($query);
            if(isset($attribute,$value)){
                $collection = $collection->where($attribute,$value);
            }
        }

        return $collection;
    }
    private function cacheResponse($data){
        $url = request()->url();
        $queryParams = request()->query();
        ksort($queryParams);
        $queryString = http_build_query($queryParams);
        $fullUrl= "{$url}?{$queryString}";
        return Cache::remember($fullUrl,30/60,function () use ($data){
           return $data;
        });
    }
    protected function errorResponse($msg,$code=409){
        return response()->json(['error' => $msg,'code' => $code],$code);
    }
    protected function showAll(Collection $collection, $code = 200){
        if($collection->isEmpty()){
            return $this->successResponse(['data' => $collection], $code);
        }
        $transformer = $collection->first()->transformer;
        $collection = $this->filterData($collection, $transformer);
        $collection = $this->sortData($collection,$transformer);
        $collection = $this->paginate($collection);
        $collection = $this->transformData($collection, $transformer);
        $collection = $this->cacheResponse($collection);
        return $this->successResponse($collection, $code);

    }
    protected function showOne(Model $instance, $code = 200){
        $transformer = $instance->transformer;
        $instance = $this->transformData($instance, $transformer);
        return $this->successResponse($instance, $code);
    }
    protected function showMessage($msg,$code=200){
        return $this->successResponse($msg,$code);
    }


}