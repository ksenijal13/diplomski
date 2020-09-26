<?php


namespace App\Models;


class Grade
{
    const GRADE_LIMIT = 8;
    private $orderByClause;
    public function getStudentGrades($userId, $offset, $year, $grade){
        $offset = ((int) $offset) * self::GRADE_LIMIT;
        $query = \DB::table("subjects_user as su")
            ->join("grades as g", "g.grade_id", "=", "su.grade_id")
            ->join("years_of_study as ys", "ys.year_id", "=", "su.year_of_study")
            ->select("*")
            ->where("student_id", $userId);
        if(!empty($year)){
            $query->orderBy("year_of_study", $year);
        }
        if(!empty($grade)){
            $query->orderBy("grade", $grade);
        }
        if(empty($year) && empty($grade)){
            $query->inRandomOrder();
        }
        return $query
            ->limit(self::GRADE_LIMIT)
            ->offset($offset)
            ->get();

    }
    public function getGrades(){
        return \DB::table("grades")
            ->get();
    }
    public function insertGrade($gradeId, $subjectId){
        \DB::table("subjects_user")
            ->where("subject_id", $subjectId)
            ->update([
                "grade_id" => $gradeId
                ]);
    }
    public function getGradeInfo($gradeId){
        return \DB::table("grades")
            ->select("*")
            ->where("grade_id", $gradeId)
            ->first();
    }
    public function countGrades($studentId){
        return \DB::table("subjects_user")
            ->select(\DB::raw("COUNT(*) as number"))
            ->where("student_id", $studentId)
            ->first();
    }
    public function averageGrade($userId){
        return \DB::table("subjects_user as su")
            ->join("grades as g", "g.grade_id", "=", "su.grade_id")
            ->where([
                ["student_id", $userId],
                ["grade", "!=", 5]
                ])
            ->avg("grade");
    }
}
