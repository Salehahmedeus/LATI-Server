<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Server;
use Illuminate\Support\Str;

class ServerController extends Controller
{
    public function store(Request $request)
    {
        $inputs=$request->validate([
            'name'=>['required','string']
        ]);

        if(Server::where('user_id',auth()->id())->exists()){
            return response()->json([
                'data' => 'you can not create more then one server'
            ], 422);
        }
        $code=$this->generateCode();
        

        auth()->user()->servers()->create([
            'name'=>$inputs['name'],
            'code'=>$code
        ]);

        return response()->json([
            'data'=>'server creation seszdscc',
            'code' => $code

        ]);

    }

    public function generateCode(){
        $code=str::random(6);
        if(Server::where('code','='.$code)->exists()){
            $this->generateCode();
        }

        return $code;
    }

    public function index(){
        $servers = Server::where('user_id', '=', auth()->id())->get();
        return response()->json([
            'data' => $servers
        ]);
    }

    public function show($code){
        $servers = Server::where('user_id', '=', auth()->id())->where('code',$code)->firstOrFial();
        return response()->json([
            'data' => $servers
        ]);
    }

    public function update(Request $request, $id)
    {
        $inputs = $request->validate([
            'name' => ['required', 'string'],
        ]);
        $server = Server::where('user_id', auth()->id())->where('id', $id)->firstOrFail();
        $server->update($inputs);
        return response()->json([
            'message' => 'server updated successfully'
        ]);
    }

    public function destroy($id){
        $server = Server::where('user_id', auth()->id())->where('id', $id)->firstOrFail();
        $server->delete();
        return response()->json([
            'data'=>'the server has been deleted secc'
        ]);
    }


}