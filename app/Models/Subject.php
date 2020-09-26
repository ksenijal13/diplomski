<?php


namespace App\Models;


class Subject
{
    const SUBJECT_LIMIT = 6;
    public function getYearsOfStudy(){
        return \DB::table("years_of_study")
            ->get();
    }
    public function addSubject($subjectName, $description, $finalDate, $studentId, $professor, $yearOfStudy, $gradeId){
        return \DB::table("subjects_user")
            ->insertGetId([
                "description" => $description,
                "final_date" => $finalDate,
                "student_id" => $studentId,
                "professor" => $professor,
                "year_of_study" => $yearOfStudy,
                "subject_name" => $subjectName,
                "grade_id" => $gradeId
            ]);
    }
    public function addExamsDates($examDate, $subjectId){
        \DB::table("subject_exams")
            ->insert([
               "exam_date" => $examDate,
               "subject_id" => $subjectId
            ]);
    }
    public function getSubjectsByYear($offset, $year, $userId, $search){
        $offset = ((int) $offset) * self::SUBJECT_LIMIT;
        if(!empty($search)){
            return $this->searchSubjects($offset, $year, $userId, $search);
        }
        return \DB::table("subjects_user as su")
            ->select("*")
            ->where([
                ["year_of_study", $year],
                ["student_id", $userId]
            ])
            ->limit(self::SUBJECT_LIMIT)
            ->offset($offset)
            ->get();
    }
    public function searchSubjects($offset, $year, $userId, $search){
        return \DB::table("subjects_user as su")
            ->select("*")
            ->where([
                ["year_of_study", $year],
                ["student_id", $userId],
                ["professor", 'LIKE', '%'.$search.'%']
            ])
            ->orWhere([
                ["year_of_study", $year],
                ["student_id", $userId],
                ["subject_name", 'LIKE', '%'.$search.'%']
            ])
            ->limit(self::SUBJECT_LIMIT)
            ->offset($offset)
            ->get();
    }
    public function getExamsDates(){
        return \DB::table("subject_exams")
            ->get();
    }
    public function getExamsForSubject($subjectId){
        return \DB::table("subject_exams")
            ->where("subject_id", $subjectId)
            ->get();
    }
    public function getOneSubject($id){
        return \DB::table("subjects_user")
            ->select("*")
            ->where("subject_id", $id)
            ->first();
    }
    public function addNewDesc($id, $desc){
        \DB::table("subjects_user")
            ->where("subject_id", $id)
            ->update([
                "description" => $desc
            ]);
    }
    public function addFinalDate($id, $finalDate){
        \DB::table("subjects_user")
            ->where("subject_id", $id)
            ->update([
                "final_date" => $finalDate
            ]);
    }
    public function countSubjects($userId, $year){
        return \DB::table("subjects_user")
            ->select(\DB::raw("COUNT(*) as number"))
            ->where([
                ["year_of_study", $year],
                ["student_id", $userId]
            ])->first();
    }
    public function countSubjectsSearch($userId, $year, $search){
        return \DB::table("subjects_user")
            ->select(\DB::raw("COUNT(*) as number"))
            ->where([
                ["year_of_study", $year],
                ["student_id", $userId],
                ["professor", 'LIKE', '%'.$search.'%']
            ])
            ->orWhere([
                ["year_of_study", $year],
                ["student_id", $userId],
                ["subject_name", 'LIKE', '%'.$search.'%']
            ])
            ->first();
    }
}
