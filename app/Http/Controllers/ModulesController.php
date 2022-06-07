<?php

namespace App\Http\Controllers;

use App\Models\Module;
use App\Models\QuestionsModule;
use App\Models\SectionsModule;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ModulesController extends Controller
{
    public function getModules()
    {
        $modules = Module::all();

        return response()->json($this->responseApi(true, ["type" => "success", "content" => "Done."], $modules), 200);
    }

    public function getUserProgress()
    {
        $user = Auth::user();

        $percent = 0;

        if ($user->module_finished == 1) {
            switch ($user->section_finished) {
                case 1:
                    $percent = 5;
                    break;
                case 2:
                    $percent = 10;
                    break;
                case 3:
                    $percent = 15;
                    break;
            }
        } else if ($user->module_finished == 2) {
            switch ($user->section_finished) {
                case 0:
                    $percent = 20;
                    break;
                case 1:
                    $percent = 25;
                    break;
                case 2:
                    $percent = 30;
                    break;
                case 3:
                    $percent = 35;
                    break;
            }
        } else if ($user->module_finished == 3) {
            switch ($user->section_finished) {
                case 0:
                    $percent = 40;
                    break;
                case 1:
                    $percent = 45;
                    break;
                case 2:
                    $percent = 50;
                    break;
                case 3:
                    $percent = 55;
                    break;
            }
        } else if ($user->module_finished == 4) {
            switch ($user->section_finished) {
                case 0:
                    $percent = 60;
                    break;
                case 1:
                    $percent = 65;
                    break;
                case 2:
                    $percent = 70;
                    break;
                case 3:
                    $percent = 75;
                    break;
            }
        } else if ($user->module_finished == 5) {
            switch ($user->section_finished) {
                case 0:
                    $percent = 80;
                    break;
                case 1:
                    $percent = 85;
                    break;
                case 2:
                    $percent = 90;
                    break;
                case 3:
                    $percent = 95;
                    break;
            }
        } else if ($user->module_finished == 6) {
            $percent = 100;
        }

        return response()->json(
            $this->responseApi(
                true,
                [
                    "type" => "success",
                    "content" => "Done."
                ],
                [
                    "percent" => $percent,
                    "moduleFinished" => $user->module_finished,
                    "sectionFinished" => $user->section_finished
                ]
            ),
            200
        );
    }

    public function getModuleSection($id)
    {
        $module = SectionsModule::with("content")->whereModuleId($id)->get();

        return response()->json($this->responseApi(true, ["type" => "success", "content" => "Done."], $module), 200);
    }

    public function getQuestions($id)
    {
        $questions = QuestionsModule::with(["answers"])->where("content_section_module_id", $id)->get();

        return response()->json($this->responseApi(true, ["type" => "success", "content" => "Done."], $questions));
    }

    public function setSectionAndModule()
    {
        $status = false;
        $result = null;
        DB::beginTransaction();
        try {
            $user = Auth::user();
            $updatedUser = User::find($user->id);
            $updatedUser->finished_module = $user->finished_module + 1;
            $updatedUser->finished_section = 0;
            $updatedUser->save();

            $status = true;
            DB::commit();
        } catch (\Throwable $th) {
            $result = $th->getMessage();
            DB::rollBack();
        }if($status){
            return response()->json($this->responseApi(false, ["type" => "success", "content" => "Done."], $updatedUser));
        }else{
            return response()->json($this->responseApi(true, ["type" => "error", "content" => "Error."], $result));
        }
    }

    public function saveSection($user_id)
    {
        $status = false;
        $result = null;
        DB::beginTransaction();
        try {
            $updatedUser = User::find($user_id);
            $updatedUser->section_finished = $updatedUser->section_finished + 1;
            $updatedUser->save();

            $status = true;
            DB::commit();
        } catch (\Throwable $th) {
            $result = $th->getMessage();
            DB::rollBack();
        }if($status){
            return response()->json($this->responseApi(true, ["type" => "success", "content" => "Done."], $updatedUser), 200);
        }else{
            return response()->json($this->responseApi(true, ["type" => "error", "content" => "No se pudo actualizar la seccion"], $result), 500);
        }
    }
}
