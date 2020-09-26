<?php

namespace App\Http\Controllers;

use App\Models\Grade;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class GradesController extends FrontController
{
    private $gradeModel;
    public function index(){
        $this->gradeModel = new Grade();
        $userId = session('user')->user_id;
        $year = null;
        $grade = null;
        $this->data["subjectsGrades"] = $this->gradeModel->getStudentGrades($userId, 0, $year, $grade);
        $this->data["grades"] = $this->gradeModel->getGrades();
        $this->data["total"] = $this->gradeModel->countGrades($userId);
        $this->data["average"] = number_format((float)$this->gradeModel->averageGrade($userId), 2, '.', '');
        return view('pages.grades', $this->data);
    }
    public function insertGrade(Request $request){
        $this->gradeModel = new Grade();
        $gradeId = $request->get("gradeId");
        $subjectId = $request->get("subjectId");
        $userId = session('user')->user_id;
        try{
            $this->gradeModel->insertGrade($gradeId, $subjectId);
            $gradeInfo = [];
            $gradeInfo[0] = $this->gradeModel->getGradeInfo($gradeId);
            $gradeInfo[1] = number_format((float)$this->gradeModel->averageGrade($userId), 2, '.', '');
            return response()->json($gradeInfo, 200);
        }catch(QueryException $e){
            return response(null, 500);
        }
    }
    public function getGrades(){
        $this->gradeModel = new Grade();
        $grades = $this->gradeModel->getGrades();
        return response()->json($grades, 200);
    }
    public function getSubjectGrade(Request $request){
        $this->gradeModel = new Grade();
        $userId = session('user')->user_id;
        $offset = $request->get("offset");
        $sortGrade = $request->get("sortGrade");
        $sortYear = $request->get("sortYear");
        $data = [];
        $data[0] = $this->gradeModel->getStudentGrades($userId, $offset, $sortYear, $sortGrade);
        $data[1] = $this->gradeModel->countGrades($userId);
        $data[2] = $this->gradeModel->getGrades();
        return response()->json($data, 200);
    }
}
