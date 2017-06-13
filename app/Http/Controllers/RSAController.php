<?php

namespace App\Http\Controllers;
use App\Model\RSA;
use Illuminate\Http\Request;

/**
 * SSH Key管理
 */
class RSAController extends Controller
{
    public function index()
    {
        return view('ssh/index');
    }

    public function create()
    {
        return view("ssh/create");
    }

    public function store(Request $request)
    {
        $rsaRequest = array_merge(
            array("user_id" => $request->user()->id), $request->all());
        try {
            $rsa = RSA::create($rsaRequest);
        } catch (\Exception $e) {

        }
        return redirect()->route("rsa.index");
    }

    public function edit($keyId)
    {
        
    }

    public function update($keyId)
    {
        echo "here";
    }

    public function delete($keyId)
    {

    }
}