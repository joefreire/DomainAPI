<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;

class StoreDomainRequest
{
    public function __construct(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'domain_name' => [
                'required',
                Rule::unique('domains')->where(function ($query) use ($request) {
                    return $query->where('domain_name', $request->domain_name)->where('tld', $request->tld);
                }), 'string', 'max:100', 'min:1'
            ],
            'tld' => 'required|string|min:3|max:10|starts_with:.',
        ]);

        if ($validator->fails())
            abort(400, $validator->errors());

        $this->map((object)$request->all());
    }

    private function map($object)
    {
        $this->domain_name = property_exists($object, 'domain_name') ? $object->domain_name : null;
        $this->tld = property_exists($object, 'tld') ? $object->tld : null;
    }

    public function parse()
    {
        $result = array(
            'domain_name' => $this->domain_name,
            'tld' => $this->tld,
        );

        return $result;
    }
}
