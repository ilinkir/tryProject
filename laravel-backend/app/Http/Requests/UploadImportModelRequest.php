<?php

namespace App\Http\Requests;

class UploadImportModelRequest extends AbstractFormRequest
{
    public function authorize()
    {
        return true;
    }
    public function rules()
    {
        return [
            'import_file' => [
                'required',
                'file',
                'mimes:csv,txt'
            ],
        ];
    }
}
