<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use phpDocumentor\Reflection\DocBlock\Tags\InvalidTag;

class ScheduleController extends FrontController
{
    private $scheduleModel;
    public function index(){
        $this->scheduleModel = new Schedule();
        $this->data["days"] = $this->scheduleModel->getDaysInWeek();
        $userId = session('user')->user_id;
        $this->data["schedule"] = $this->scheduleModel->getStudentSchedule($userId);
        $this->data["time"] = $this->scheduleModel->getStudentTime($userId);
        return view('pages.schedule', $this->data);
    }
    public function writeSchedule(Request $request){
        $this->scheduleModel = new Schedule();
        $day = $request->get("day");
        $activity = $request->get("activity");
        $time = $request->get("time");
        $user = session('user')->user_id;
        $this->scheduleModel->deleteActivity($day, $user, $time);
        $scheduleId = $this->scheduleModel->writeSchedule($day, $activity, $time, $user);
       $schedule = [];
        $schedule[0] = $this->scheduleModel->getOneSchedule($scheduleId);
        $schedule[1] = $this->scheduleModel->getDaysInWeek();
        return response()->json($schedule, 201);
    }
    public function deleteSchedule(){
        $this->scheduleModel = new Schedule();
        $user = session('user')->user_id;
        try{
            $this->scheduleModel->deleteSchedule($user);
            return redirect()->back();
        }catch(QueryException $e){
            return redirect()->back()->with("message", "Dogodila se greška. Molimo Vas, pokušajte kasnije.");
        }
    }
}
