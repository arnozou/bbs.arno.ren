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
    $categories = $this->categoryR->getChildren(0);
    $categories = $this->categoryR->loadLastReplies($categories);
    // dump($categories);

    return $this->response->collection($categories, new CategoryTransformer());
  }

  public function store(Request $request)
  {
  }

  public function show(Request $request, $categoryId)
  {
    return $this->response->collection($this->categoryR->getChildren($categoryId), new CategoryTransformer());
  }  
}
