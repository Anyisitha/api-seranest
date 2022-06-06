<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->only("email", "password");

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $activeUser = User::whereStatusId($this->activeStatus)->find($user->id);
            if (isset($activeUser->id)) {
                $token = $activeUser->createToken("Roche")->accessToken;
                return response()->json($this->responseApi(true, array("type" => "Success", "content" => "Bienvenido."), array("token" => $token, "user" => $activeUser)));
            } else {
                return response()->json($this->responseApi(false, array("type" => "Unauthorizate", "content" => "No estas autorizado para ingresar."), array()), 401);
            }
        } else {
            return response()->json($this->responseApi(false, array("type" => "Not Found", "content" => "Los datos ingresados no existen."), array()), 404);
        }
    }

    public function register(Request $request)
    {
        $status = false;
        $result = null;
        DB::beginTransaction();
        try {
            $user = new User();
            $user->uid = Hash::make($request->fullname);
            $user->fullname = $request->fullname;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->document_type = $request->document_type;
            $user->document = $request->document;
            $user->country = $request->country;
            $user->city = $request->city;
            $user->status_id = $this->activeStatus;
            $user->nationality = $request->nationality;
            $user->finished_module = 0;
            $user->finished_section = 0;
            $user->address = $request->address;
            $user->save();

            $user->assignRole("Admin");

            $status = true;
            DB::commit();
        } catch (\Throwable $th) {
            $result = $th->getMessage();
            DB::rollBack(); 
        }if ($status){
            return response()->json($this->responseApi(true, ["type" => "Success", "content" => "Done."], $user), 200);
        }else{
            return response()->json($this->responseApi(true, ["type" => "Success", "content" => "Done."], $result), 200);
        }
    }
}
