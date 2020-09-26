<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class UserController extends Controller
{
    private $model;
    private $userId;
    public function __construct()
    {
        $this->model = new User();
        if(session()->has('user')) {
            $this->userId = session("user")->user_id;
        }
    }
    public function changeStudyYear($year)
    {
        try{
            $this->model->changeStudyYear($this->userId, $year);
            return response(null, 204);
        }catch (QueryException $e){
            return response(null, 500);
        }
    }
    public function updateUserInfo(Request $request){
        $university = $request->input("university");
        $module = $request->input("module");
        $year = $request->input("year-of-study");
        if(!empty($university)){
            try{
                $this->model->updateUniversity($this->userId, $university);
                //return redirect()->back();
            }catch(QueryException $e){
                return redirect()->back()->with("message", "Dogodila se greška. Molimo Vas, pokušajte kasnije.");
            }
        }
        if(!empty($module)){
            try{
                $this->model->updateModule($this->userId, $module);
               // return redirect()->back();
            }catch(QueryException $e){
                return redirect()->back()->with("message", "Dogodila se greška. Molimo Vas, pokušajte kasnije.");
            }
        }
        if(!empty($year)){
            try{
                $this->model->changeStudyYear($this->userId, $year);
                //return redirect()->back();
            }catch(QueryException $e){
                return redirect()->back()->with("message", "Dogodila se greška. Molimo Vas, pokušajte kasnije.");
            }
        }
        return redirect()->back();
    }
    public function getUsers(Request $request){
        $offset = $request->get("offset");
        $userModel = new User();
        $users = $userModel->getAllUsers($offset);
        return response()->json($users, 200);
    }
    public function deleteUser(Request $request){
        $userId = $request->get("userId");
        $offset = $request->get("offset");
        $this->model = new User();
        try{
            $this->model->deleteUserLink($userId);
            $this->model->deleteUserTime($userId);
            $this->model->deleteUserUniversity($userId);
            $this->model->deleteUserSubject($userId);
            $this->model->deleteUser($userId);
            $data = [];
            $data[0] = $this->model->getAllUsers($offset);
            if(!count($data[0])){
                $data[0] = $this->model->getAllUsers($offset-1);
            }
            $data[1] = $this->model->countUsers()->number / 6;
            return response()->json($data, 200);
        }catch (QueryException $e){
            return response(null, 500);
        }
    }

    public function regainAccess(Request $request){
        $email = $request->post("email");
    }

    public function checkPassword(Request $request){
        $userPass = $request->post("mail-password");
        $mailPass = $request->session()->get("new-password");
       // dd($mailPass);
        //dd($userPass);
        $x = $userPass == $mailPass;
        //dd($x);
        if($userPass == $mailPass){
            $request->session()->put("correct", "correct");
            return redirect("/edit-password");
        }else{
            $request->session()->put("incorrect", "incorrect");
            return redirect()->back();
        }
    }
    public function editPassword(Request $request){
        $email = $request->session()->get("email");
        $password = $request->post("password");
        $userModel = new User();
        try{
            $userModel->editPassword($email, $password);
            return redirect('/');
        }catch(QueryException $e){
            $request->session()->put("error", "error");
            return redirect()->back();
        }
    }
}
