<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    private $model;
    public function __construct()
    {
        $this->model = new User();
    }

    public function login(LoginRequest $request){
        $username = $request->post("username");
        $password = $request->post("password");
        $user = $this->model->login($username, $password);
        if($user){
            $request->session()->put("user", $user);
            if(session('user')->role_id == 2){
                return response()->json(['userRole' => 'admin'], 200);
            }else{
                return response()->json(['userRole' => 'user'], 200);
            }
        }else{
            return response(null, 404);
        }
    }
    public function register(RegisterRequest $request){
        $firstName = $request->post("firstName");
        $lastName = $request->post("lastName");
        $username = $request->post("username");
        $password = $request->post("password");
        $email = $request->post("email");
        $gender = $request->post("gender");
        $roleId = 1;
        try{
            $result = $this->model->register($firstName, $lastName, $username, $password, $email, $roleId, $gender);
            if($result){
              return response(null, 200);
            }
        }catch(QueryException $e){
            return response(null, 409);
        }
    }
    public function logout(Request $request){
        $request->session()->forget("user");
        $request->session()->flush();
        return redirect("/");
    }
}
