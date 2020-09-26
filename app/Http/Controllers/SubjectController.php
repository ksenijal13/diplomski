<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class SubjectController extends FrontController
{
    private $subjectModel;
    public function index()
    {
        $subjectModel = new Subject();
        $this->data['years'] = $subjectModel->getYearsOfStudy();
        return view('pages.subjects', $this->data);
    }
    public function getSubjectsByYear($year)
    {
        $userId = session('user')->user_id;
        $subjectModel = new Subject();
        $this->data["year"] = $year;
        $offset = 0;
        $search = null;
        $this->data["subjects"] = $subjectModel->getSubjectsByYear($offset, $year, $userId, $search);
        $this->data["exams"] = $subjectModel->getExamsDates();
        $this->data["total"] = $subjectModel->countSubjects($userId, $year);
        return view('pages.year-subjects', $this->data);
    }
    public function addSubject(Request $request){
        $subjectModel = new Subject();
        $studentId = session('user')->user_id;
        $year = $request->post("year");
        $subjectName = $request->post("subject-name");
        $subjectProfessor = $request->post("subject-professor");
        $subjectDesc = $request->post("subject-desc");
        $finalDate = $request->post("final-date");
        $examsDates = $request->post("exam");
        $gradeId = 7;
        try {
            $subjectId = $subjectModel->addSubject($subjectName, $subjectDesc, $finalDate, $studentId, $subjectProfessor, $year, $gradeId);
            if(sizeof($examsDates) > 0){
                foreach($examsDates as $exam){
                    $subjectModel->addExamsDates($exam, $subjectId);
             }
           }
            $request->session()->put("success", "success");
            return redirect()->back();
        }catch(QueryException $e){
            return redirect()->back()->with("message", "Dogodila se greška. Molimo Vas, pokušajte kasnije.");
        }
    }
    public function addNewExamDate(Request $request){
        $date = $request->input("date");
        $subjectId = $request->input("subjectId");
        $subjectModel = new Subject();
        try{
            $subjectModel->addExamsDates($date, $subjectId);
            $subject = $subjectModel->getOneSubject($subjectId);
            return response()->json($subject, 201);
        }catch(QueryException $e){
            return response(null, 500);
        }
    }
    public function getSubjectsExams(Request $request){
        $subjectModel = new Subject();
        $subjectId = $request->input("subjectId");
        try{
            $exams = $subjectModel->getExamsForSubject($subjectId);
            return response()->json($exams, 200);
        }catch(QueryException $e){
            return response(null, 500);
        }
    }
    public function addNewDesc(Request $request){
        $subjectModel = new Subject();
        $id = $request->get("id");
        $desc = $request->get("description");
        try{
            $subjectModel->addNewDesc($id, $desc);
            return response(null, 204);
        }catch(QueryException $e){
            return response(null, 500);
        }
    }
    function addFinalDate(Request $request){
        $subjectModel = new Subject();
        $id = $request->input("id");
        $finalDate = $request->input("finalDate");
        try{
            $subjectModel->addFinalDate($id, $finalDate);
            return response(null, 204);
        }catch(QueryException $e){
            return response(null, 500);
        }
    }
    function destroySession(Request $request){
        $request->session()->forget("success");
        return response(null, 200);
    }
    function getSubjectsWithOffset(Request $request){
        $subjectModel = new Subject();
        $userId = session('user')->user_id;
        $offset = $request->input("offset");
        $year = $request->input("year");
        $search = $request->input("searchValue");
        $info = [];
        $subjects = $subjectModel->getSubjectsByYear($offset, $year, $userId, $search);
        $info[0] = $subjects;
       if(!empty($search)){
           $info[1] = $subjectModel->countSubjectsSearch($userId, $year, $search);
       }else{
           $info[1] = $subjectModel->countSubjects($userId, $year);
       }
        return response()->json($info, 200);
    }
}
