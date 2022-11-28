<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

class UpdatePersonRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name'=>"required|alpha|size:4",
            'last_name'=>"required|alpha|size:4",
            'age'=>["required","numeric","gt:18",Rule::prohibitedIf($this->invalidAge($this->age, $this->birthday))],
            'birthday'=>"required|date|date_format:Y-m-d|before:registered|before:today",
            'registered'=>"required|date|date_format:Y-m-d|gte:birthday|before:today",
            'price'=>['required','numeric',Rule::prohibitedIf($this->invalidPrice($this->price, $this->registered))],
        ];
    }

    function invalidAge($age, $birthday){
        $edad = Carbon::parse($birthday)->age;
        return $edad != $age;
    }

    function invalidPrice($price, $registered){
        $price_time = (Carbon::parse($registered)->age)*100;
        return $price_time != $price;
    }

}
