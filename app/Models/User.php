<?php


namespace App\Models;


class User
{
    const USER_LIMIT = 6;

    public function login($username, $password){
        return \DB::table("users")
            ->select("*")
            ->where([
                ['username', $username],
                ['password', md5($password)]
            ])->first();
    }
    public function register($firstName, $lastName, $username, $password, $email, $role_id, $genderId){
        $id =  \DB::table("users")
            ->insertGetId([
                "first_name" => $firstName,
                "last_name" => $lastName,
                "username" => $username,
                "password" => md5($password),
                "email" => $email,
                "role_id" => $role_id,
                "gender_id" => $genderId
            ]);
            \DB::table("student_university")
                ->insert([
                   "student_id" => $id,
                    "active" => true
                ]);
    }
    public function getUserInfo($id){
        return \DB::table("users as u")
            ->leftJoin("student_university as su", "su.student_id", "=", "u.user_id")
            ->select("*")
            ->where("user_id", $id)
            ->first();
    }
    public function changeStudyYear($id, $year){
        \DB::table("student_university")
            ->where("student_id", $id)
            ->update(
              [
                  "year_of_study" => $year
              ]
            );
    }
    public function updateUniversity($id, $uni){
        \DB::table("student_university")
            ->where("student_id", $id)
            ->update(
                [
                    "university" => $uni
                ]
            );
    }
    public function updateModule($id, $module){
        \DB::table("student_university")
            ->where("student_id", $id)
            ->update(
                [
                    "module" => $module
                ]
            );
    }
    function getAllUsers($offset){
        $offset = ((int) $offset) * self::USER_LIMIT;
        return \DB::table("users")
            ->select("*")
            ->where("role_id", 1)
            ->limit(self::USER_LIMIT)
            ->offset($offset)
            ->get();
    }
    function countUsers(){
        return \DB::table("users")
            ->select(\DB::raw("COUNT(*) as number"))
            ->where("role_id", 1)
            ->first();
    }
    function deleteUser($userId){
        \DB::table("users")
            ->where("user_id", $userId)
            ->delete();
    }
    function editPassword($email, $password){
        \DB::table("users")
            ->where("email", $email)
            ->update([
               "password" => md5($password)
            ]);
    }
    function deleteUserLink($userId){
        \DB::table("important_links")
            ->where("user_id", $userId)
            ->delete();
    }
    function deleteUserTime($userId){
        \DB::table("student_time_day")
            ->where("student_id", $userId)
            ->delete();
    }
    function deleteUserUniversity($userId){
        \DB::table("student_university")
            ->where("student_id", $userId)
            ->delete();
    }
    function deleteUserSubject($userId){
        \DB::table("subject_exams as se")
            ->join("subjects_user as su", "su.subject_id", "=", "su.subject_id")
            ->where("student_id", $userId)
            ->delete();
    }
}
