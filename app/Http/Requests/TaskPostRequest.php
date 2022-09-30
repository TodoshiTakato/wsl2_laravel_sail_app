<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TaskPostRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'nullable | max:255',
            'details' => 'nullable | string | min:10 | max:65535',
            'status' => 'nullable | integer | between:0,1',
            'priority' => 'nullable | integer | between:0,5',
            'start_time' => 'nullable | date_format:Y-m-d\TH:i',
            'finish_time' => 'nullable | date_format:Y-m-d\TH:i',
            'time_spent' => 'nullable | integer',
            'rating' => 'nullable | integer | between:1,5',
            'comment' => 'nullable | string',
        ];
    }

//    public function messages()
//    {
//        return [
//            'name.required' => 'Вы должны ввести название таски!',
//        ];
//    }

//    public function withValidator($validator)
//    {
//        if (!$validator->fails()) {
//            $validator->after(function ($validator) {
//
//                if (Cache::has($this->mobile)) {
//                    if (Cache::get($this->mobile) != $this->code) {
//                        $validator->errors()->add('code', 'code is incorrect!');
//                    } else {
//                        $this->user = User::where('mobile', $this->mobile)->first();
//                    }
//                } else {
//                    $validator->errors()->add('code', 'code not found!');
//                }
//
//                if(!$this->checkAvailable($this->input(['check_in', 'check_out']))){
//                    $validator->errors()->add('unavailable', 'The dates you selected are busy!');
//                }
//
//            });
//        }
//    }

//    public function afterValidator($validator)
//    {
//        if ($this->somethingElseIsInvalid()) {
//            $validator->errors()->add('field', 'Something is wrong with this field!');
//        };
//    }



}
