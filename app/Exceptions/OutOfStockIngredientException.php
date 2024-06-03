<?php

namespace App\Exceptions;

use App\Models\Ingredient;
use App\Models\Product;
use Exception;

class OutOfStockIngredientException extends Exception
{
    protected $message;

    protected $code = 422;

    public function __construct(Ingredient $ingredient, Product $product)
    {
        $this->message .= "Unable to process this order as there is an out of stock ingredient {$ingredient->name} for product {$product->name}";
        parent::__construct($this->message, $this->code);
    }

}
