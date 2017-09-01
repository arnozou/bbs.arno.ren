<?php namespace App\Repositories;

use Illuminate\Container\Container as App;
use App\Repositories\Interfaces\RepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use Validator;

abstract class Repository implements RepositoryInterface {

  protected $model;
  protected $rules;
  public function __construct(App $app)
  {
    $this->app = $app;
    $this->makeModel(); 
    $this->makeRules(); 
  }

  /**
   * 指定 model 类名
   * @return string 
   */
  abstract public function model();

  protected function makeModel()
  {
    $model = $this->app->make($this->model());
    
    if ( ! $model instanceof Model ) {
      throw new \Exception("Class {$model} must be an instance of Illuminate\\Database\\Eloquent\\Model");
    }
    return $this->model = $model;
  }

  public function resetmodel($model = null)
  {
    $modelClass = $this->model();
    if ($model instanceof $modelClass ) {
       $this->model = $model;
       return;
    }
    $this->makeModel();
  }

  public function rules()
  {
    return null;
  }

  public function makeRules()
  {
    if (is_array($this->rules())) {
      $this->rules = $this->rules();
    } else {
      throw new Exception('rules must return an array');
    }
  }

  /**
   * [指定验证器]
   * @return string|object 验证器类名或类
   */
  public function validator()
  {
    return '\Illuminate\Validation\Validator';
  }

  protected function makeValidatoer()
  {
    $validator = $this->validator();
    if (!is_null($validator)) {
      $this->validator = is_string($validator) ? $this->app->make($validator) : $validator;

      if (!$this->validator instanceof \Illuminate\Validation\Validator) {
        throw new Exception("Class {$validator} must be an instance of \\Illuminate\\Validation\\Validator");
      }

      return $this->validator;  
    }

    return null;
  }

  public function validate(array $datas, $rules = null)
  {
    $rules = is_null($rules) ? $this->rules : $rules;
    if (is_null($rules)) {
      throw new Exception('validate rules is not set');
    }
    $validator = Validator::make($datas, $rules);

    if ($validator->fails()) {
      throw new \Dingo\Api\Exception\ValidationHttpException($validator->errors());
    }
  }


  

  public function all($columns = ['*'])
  {
    $results = $this->model->get($columns);
    $this->resetModel();

    return $results;
  }

  public function first($columns = ['*'])
  {
    $results = $this->model->first($columns);
    $this->resetModel();

    return $results;
  }
  /**
   * Retrieve first data of repository, or return new Entity
   *
   * @param array $attributes
   *
   * @return mixed
   */
  public function firstOrNew(array $attributes = [])
  {
    $results = $this->model->firstOrNew($attributes);
    $this->resetModel();

    return $results;
  }
  public function find($id, $columns = ['*'])
  {
    $results = $this->model->find($id, $columns);
    $this->resetModel();

    return $results;
  }

  public function findByField($field, $value, $columns = ['*'])
  {
    $model = $this->model->where($field, '=', $value)->get($columns);
    $this->resetModel();

    return $model;
  }

  public function findWhere(array $where, $columns = ['*'])
  {
    $model = $this->model->where($where)->get($columns);
    $this->resetModel();

    return $model;
  }

  public function create(array $attributes)
  {
    return $this->model->create($attributes);
  }

  public function update(array $attributes, $id)
  {
    $model = $this->model->findOrFail($id);
    $model->fill($attributes);
    $model->save();
  }

  public function delete($id)
  {
    return $this->model->delete($id);
  }

  public function orderBy($column, $direction = 'asc')
  {
    $this->model->orderBy($column, $direction);
    return $this;
  }

  public function limit($limit)
  {
    $this->model->limit($limit);
    return $this;
  }

  public function with($relations)
  {
    $this->model = $this->model->with(
      is_string($relations) ? func_get_args() : $relations
      );
    return $this;
  }


}