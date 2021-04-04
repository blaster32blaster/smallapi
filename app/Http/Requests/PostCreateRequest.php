<?php

namespace App\Http\Requests;

use App\Models\File;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class PostCreateRequest extends FormRequest
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
        logger()->error(json_encode($this->request->get('owner')));
        // $ownerId = $this->ownerId();
        return [
            'id' => 'string',
            'title' => 'string|required',
            'body' => 'string|required',
            'owner' => [
                'required',
                function ($attribute, $value, $fail) {
                    return $this->validateOwner($attribute, $value, $fail);
                }
            ],
            'main_image' => [
                'required',
                function ($attribute, $value, $fail) {
                    return $this->validateFile($attribute, $value, $fail);
                }
            ],
            'tags' => 'array'
        ];
    }

    /**
     * validate the file
     *
     * @param mixed $attribute
     * @param array $value
     * @param mixed $fail
     * @return void
     */
    private function validateFile($attribute, $value, $fail)
    {
        if (is_string($value) || is_integer($value)) {
            return;
        }

        if (!array_key_exists('id', $value)) {
            $fail('The ' . $attribute . ' is invalid.');
            return $fail;
        }

        if (!File::where('id', '=', $value['id'])->count() > 0) {
            $fail('The ' . $attribute . ' is invalid.');
            return $fail;
        }
    }

    /**
     * validate the user
     *
     * @param mixed $attribute
     * @param array $value
     * @param mixed $fail
     * @return void
     */
    private function validateOwner($attribute, $value, $fail)
    {
        if (is_string($value) || is_integer($value)) {
            return;
        }

        if (!array_key_exists('id', $value)) {
            $fail('The ' . $attribute . ' is invalid.');
            return $fail;
        }

        if (!User::where('id', '=', $value['id'])->count() > 0) {
            $fail('The ' . $attribute . ' is invalid.');
            return $fail;
        }
    }
}
