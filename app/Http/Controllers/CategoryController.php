<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\Interfaces\CategoryInterface;
use App\Transformers\CategoryTransformer;

class CategoryController extends ApiController
{
    public function index(Request $request, CategoryInterface $categoryRepository)
    {
      return $this->response->collection($categoryRepository->getChildren(0), new CategoryTransformer());
    }

    public function store()
    {
      
    }
}
