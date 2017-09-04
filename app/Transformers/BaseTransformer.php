<?php 
namespace App\Transformers;

use League\Fractal\TransformerAbstract;

class BaseTransformer extends TransformerAbstract {
    use Traits\CarbonTrait;
}