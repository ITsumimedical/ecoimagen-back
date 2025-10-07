
<?php

namespace App\Http\Modules\Historia\Pdfs\Requests;

use Illuminate\Foundation\Http\FormRequest;


class SubirPdfRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'pdf' => 'required|file|mimes:pdf|max:5120',
        ];
    }
}
