<?php

namespace App\Http\Controllers\Category;

use App\Category;
use App\Http\Controllers\ApiController;
use App\Transformers\CategoryTransformer;
use Illuminate\Http\Request;

class CategoryController extends ApiController
{
    public function __construct()
    {
        $this->middleware('transform.input:'.CategoryTransformer::class)->only(['store','update']);
        $this->middleware('auth:api')->except(['index','show']);
        $this->middleware('client.credentials')->only(['index','show']);
    }
    public function index() {
        return $this->showAll(Category::all());
    }

    public function store(Request $request) {
        $rules = [
            'name'          => 'required',
            'description'   => 'required',
        ];
        $this->validate($request,$rules);
        $category = Category::create($request->all());
        return $this->showOne($category);
    }

    public function show(Category $category) {
        return $this->showOne($category);
    }

    public function update(Request $request, Category $category) {
        $category->fill($request->intersect(['name','description']));
        if($category->isClean()){
            return $this->errorResponse('Specify different values to update',422);
        }
        $category->save();
        return $this->showOne($category);
    }

    public function destroy(Category $category) {
        $category->delete();
        return $this->showOne($category);
    }
}
