<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use Carbon\Carbon;

class BulkDomainRequest
{
    private $data = [];
    private $errors = [];
    public function __construct(Request $request)
    {

        foreach ($request->all() as $input) {
            $validator = Validator::make($input, [
                'domain_name' => [
                    'required',
                    Rule::unique('domains')->where(function ($query) use ($input) {
                        return $query->where('domain_name', $input['domain_name'])->where('tld', $input['tld']);
                    }), 'string', 'max:100', 'min:1'
                ],
                'tld' => 'required|string|min:3|max:10|starts_with:.',
            ]);
            if ($validator->fails()) {
                $this->errors[] = $input;
            } else {
                $this->data[] = $input;
            }
        }
    }

    public function parse()
    {
        $result = [];
        foreach ($this->data as $data) {
            $result[] = ['domain_name' => $data['domain_name'], 'tld' => $data['tld']];
        }
        return $result;
    }

    public function getErrors()
    {
        return $this->errors;
    }
}
