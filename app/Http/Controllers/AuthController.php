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
            $activeUser = User::whereStatusId(1)->find($user->id);
            if (isset($activeUser->id)) {
                $token = $activeUser->createToken("Roche")->accessToken;
                return response()->json($this->responseApi(true, array("type" => "success", "content" => "Bienvenido."), array("token" => $token, "user" => $activeUser)));
            } else {
                return response()->json($this->responseApi(false, array("type" => "unauthorizate", "content" => "No estas autorizado para ingresar."), array()), 401);
            }
        } else {
            return response()->json($this->responseApi(false, array("type" => "not found", "content" => "Los datos ingresados no existen."), array()), 404);
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
            $user->status_id = 1;
            $user->nationality = $request->nationality;
            $user->module_finished = 0;
            $user->section_finished = 0;
            $user->address = $request->address;
            $user->especiality = $request->especiality;
            $user->resident_year = $request->especiality_year;
            $user->work_address = $request->work_address;
            $user->phone = $request->phone;
            $user->save();

            $status = true;
            DB::commit();
        } catch (\Throwable $th) {
            $result = $th->getMessage();
            DB::rollBack();
        }if ($status){
            return response()->json($this->responseApi(true, ["type" => "success", "content" => "Done."], $user), 200);
        }else{
            return response()->json($this->responseApi(true, ["type" => "error", "content" => "Error."], $result), 500);
        }
    }

    public function changePassword(Request $request)
    {
        $status = false;
        $result = null;
        DB::beginTransaction();
        try {
            $searchUser = User::where("email", $request->email)->first();
            if(isset($searchUser->id)){
                $searchUser->password = Hash::make($request->password);
                $searchUser->save();
            }else{
                return response()->json($this->responseApi(true, ["type" => "not found", "content" => "El usuario no existe."], $result), 404);
            }

            $status = true;
            DB::commit();
        } catch (\Throwable $th) {
            $result = $th->getMessage();
            DB::rollBack();
        }if ($status) {
            return response()->json($this->responseApi(true, ["type" => "success", "content" => "Done."], $searchUser), 200);
        } else {
            return response()->json($this->responseApi(true, ["type" => "error", "content" => "Error."], $result), 500);
        }
    }
}
