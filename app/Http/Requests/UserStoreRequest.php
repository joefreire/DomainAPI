<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
class UserStoreRequest
{
    public function __construct(Request $request)
    {
        $data = $request->all();
        $validator = Validator::make($data, [
            'name' => 'required|max:100|min:5',
            'password' => 'required|max:100|min:8',
            'email' => 'required|email|unique:users',
        ]);

        if ($validator->fails())
            abort(400, $validator->errors());

        $this->map((object)$data);
    }

    private function map($object)
    {
        $this->name = property_exists($object, 'name') ? $object->name : null;
        $this->password = property_exists($object, 'password') ? $object->password : null;
        $this->email = property_exists($object, 'email') ? $object->email : null;
    }

    public function parse()
    {
        $result = array(
            'name' => $this->name,
            'password' => $this->password,
            'email' => $this->email
        );

        return $result;
    }
}
