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
    $parentId = $request->input('parent_id', 0);
    if ((int)$parentId == -1) {
      return $this->response->collection($this->categoryR->all(), new CategoryTransformer());
    }

    $categories = $this->categoryR->getChildren($parentId);
    $categories = $this->categoryR->loadLastReplies($categories);
    // dump($categories);

    return $this->response->collection($categories, new CategoryTransformer());
  }

  public function store(Request $request)
  {
  }

  public function show(Request $request, $categoryId)
  {
    $categories = $this->categoryR->getChildren($categoryId);
    $categories = $this->categoryR->loadLastReplies($categories);

    return $this->response->collection($categories, new CategoryTransformer());
  }  
}
