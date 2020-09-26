<?php


namespace App\Models;


class Schedule
{
    public function getDaysInWeek(){
        return \DB::table("days_in_week")
            ->get();
    }
    public function writeSchedule($day, $activity, $time, $userId){
        return \DB::table("student_time_day")
            ->insertGetId([
               "student_id" => $userId,
               "day_id" => $day,
               "time" => $time,
                "activity" => $activity
            ]);
    }
    public function getOneSchedule($id){
        return \DB::table("student_time_day")
            ->where("std_id", $id)
            ->first();
    }
    public function deleteActivity($day, $user, $time){
         \DB::table("student_time_day")
           ->where([
               ["day_id", "=", $day],
               ["student_id", "=", $user],
               ["time", "=", $time]
           ])->delete();
    }
    public function getStudentSchedule($id){
        return \DB::table("student_time_day")
            ->where("student_id", $id)
            ->orderBy("time", "asc")
            ->get();
    }
    public function getStudentTime($id){
        return \DB::table("student_time_day")
            ->select("time")
            ->where("student_id", $id)
            ->orderBy("time", "asc")
            ->distinct()
            ->get();
    }
    public function deleteSchedule($userId){
         \DB::table("student_time_day")
            ->where("student_id", $userId)
            ->delete();
    }
}
