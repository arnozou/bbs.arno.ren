<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\Interfaces\CategoryInterface;
use App\Transformers\CategoryTransformer;

class CategoryController extends ApiController
{
  public function __construct(CategoryInterface $categoryRepository)
  {
    $this->categoryR = $categoryRepository;
  }
  public function index(Request $request)
  {
    return $this->response->collection($this->categoryR->getChildren(0), new CategoryTransformer());
  }

  public function store(Request $request)
  {
  }

  public function show(Request $request, $categoryId)
  {
    return $this->response->item($this->categoryR->getChildren($categoryId), new CategoryTransformer());
  }  
}
