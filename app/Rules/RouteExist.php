<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\URL;

class RouteExist implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct(){}

    /**
     * Determine if the validation rule passes.
     * Rule to check if a certain route is defined in API
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $routes = \Route::getRoutes();
        $request = \Request::create(URL::to('/').$value);
        try {
            $routes->match($request);
            return true;
        }
        catch (\Symfony\Component\HttpKernel\Exception\NotFoundHttpException $e){
            return false;
        }
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'A route inserida não está definida na API.';
    }
}
