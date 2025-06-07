<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Document;

class DocumentRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'type' => 'required|string|in:' . implode(',', array_keys(Document::getTypeOptions())),
            'number' => [
                'required',
                'string',
                'max:100',
                function ($attribute, $value, $fail) {
                    $date = $this->input('date');
                    $id = $this->route('document')?->id;

                    if (Document::isDuplicateNumberInSameYear($value, $date, $id)) {
                        $message = Document::getDuplicateMessage($value, $date);
                        $fail($message);
                    }
                },
            ],
            'second_number' => 'nullable|string|max:100',
            'date' => 'required|date',
            'source_file' => 'required|string',
            'description' => 'nullable|string',
            'other' => 'nullable|string',
            'files' => 'nullable|array',
            'files.*' => 'file|max:10240', // 10MB
        ];
    }

    public function messages()
    {
        return [
            'type.required' => 'សូមជ្រើសរើសប្រភេទឯកសារ',
            'number.required' => 'សូមបញ្ចូលលេខរាងឯកសារ',
            'number.max' => 'លេខរាងឯកសារមិនអាចលើសពី 100 តួអក្សរទេ',
            'date.required' => 'សូមជ្រើសរើសកាលបរិច្ឆេទ',
            'source_file.required' => 'សូមបញ្ចូលប្រភពឯកសារ',
            'files.*.max' => 'ឯកសារមិនអាចលើសពី 10MB ទេ',
        ];
    }
}
