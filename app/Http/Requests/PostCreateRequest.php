<?php

namespace app\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostCreateRequest extends FormRequest
{
    public function rules(){
        return [
            'post_title' => 'required',
            'post_description' => 'required',
            'post_publish_date' => 'required',
            'post_status' => 'required',
        ];
    }
}
