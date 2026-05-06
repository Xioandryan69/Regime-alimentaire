<?php

namespace App\Controllers;

use Config\Database;
use App\Models\GradeModel;

class StudentController extends BaseController
{
    public function index()
    {
        $db = Database::connect();

        $students = $db->table('etudiant')
            ->select('etudiant.*, GROUP_CONCAT(parcours.nom ORDER BY parcours.nom SEPARATOR ", ") as parcours_nom')
            ->join('etudiant_parcours', 'etudiant_parcours.etudiant_id = etudiant.id', 'left')
            ->join('parcours', 'parcours.id = etudiant_parcours.parcours_id', 'left')
            ->groupBy('etudiant.id')
            ->orderBy('etudiant.nom', 'ASC')
            ->get()
            ->getResultArray();

        return view('students_list', [
            'students' => $students,
        ]);
    }

    public function show(int $id)
    {
        $db = Database::connect();

        $student = $db->table('etudiant')
            ->select('etudiant.*, GROUP_CONCAT(parcours.nom ORDER BY parcours.nom SEPARATOR ", ") as parcours_nom')
            ->join('etudiant_parcours', 'etudiant_parcours.etudiant_id = etudiant.id', 'left')
            ->join('parcours', 'parcours.id = etudiant_parcours.parcours_id', 'left')
            ->groupBy('etudiant.id')
            ->where('etudiant.id', $id)
            ->get()
            ->getRowArray();
        if (!$student) {
            return redirect()->to('/students');
        }

        $semester = $this->request->getGet('semester') ?? 'S3';
        $semester = strtoupper($semester);
        $semester = in_array($semester, ['S3', 'S4', 'L2'], true) ? $semester : 'S3';

        $optionOverride = strtolower((string) ($this->request->getGet('option') ?? ''));
        $optionMap = [
            'dev' => 1,
            'bddres' => 2,
            'web' => 3,
        ];
        $parcoursId = $this->resolveParcoursId($id, $optionOverride, $optionMap);
        if ($parcoursId !== null && $optionOverride === '') {
            $optionOverride = array_search($parcoursId, $optionMap, true) ?: '';
        }

        if ($parcoursId === null) {
            return view('student_notes', [
                'student' => $student,
                'semester' => $semester,
                'optionOverride' => $optionOverride,
                'summaryS3' => ['rows' => [], 'average' => null, 'total_credits' => 0, 'total_credits_obtained' => 0],
                'summaryS4' => ['rows' => [], 'average' => null, 'total_credits' => 0, 'total_credits_obtained' => 0],
                'l2Average' => null,
                'history' => [],
            ]);
        }

        $programmeS3 = $this->getProgrammeBySemester($parcoursId, 3);
        $programmeS4 = $this->getProgrammeBySemester($parcoursId, 4);

        $maxGrades = $this->getMaxGradesByUe($id);
        $allNotes = $this->getAllNotesByUe($id);
        $history = $this->getGradeHistory($id, $parcoursId);

        $summaryS3 = $this->buildSemesterSummary('S3', $programmeS3, $maxGrades, $allNotes);
        $summaryS4 = $this->buildSemesterSummary('S4', $programmeS4, $maxGrades, $allNotes);

        $l2Average = $this->computeL2Average($summaryS3['average'], $summaryS4['average']);

        return view('student_notes', [
            'student' => $student,
            'semester' => $semester,
            'optionOverride' => $optionOverride,
            'summaryS3' => $summaryS3,
            'summaryS4' => $summaryS4,
            'l2Average' => $l2Average,
            'history' => $history,
        ]);
    }

    private function getProgrammeBySemester(int $parcoursId, int $semesterNum): array
    {
        $db = Database::connect();

        return $db->table('programme')
            ->select('ue.id as ue_id, ue.nom as ue_nom, ue.code, ue.credits, programme.type, programme.groupe_choix, semestre.numero')
            ->join('ue', 'ue.id = programme.ue_id')
            ->join('semestre', 'semestre.id = programme.semestre_id')
            ->where('programme.parcours_id', $parcoursId)
            ->where('semestre.numero', $semesterNum)
            ->orderBy('programme.type', 'ASC')
            ->orderBy('programme.groupe_choix', 'ASC')
            ->orderBy('ue.nom', 'ASC')
            ->get()
            ->getResultArray();
    }

    private function resolveParcoursId(int $studentId, string $optionOverride, array $optionMap): ?int
    {
        $db = Database::connect();

        if ($optionOverride !== '' && array_key_exists($optionOverride, $optionMap)) {
            return $optionMap[$optionOverride];
        }

        $row = $db->table('etudiant_parcours')
            ->select('parcours_id')
            ->where('etudiant_id', $studentId)
            ->orderBy('parcours_id', 'ASC')
            ->get()
            ->getRowArray();

        return $row ? (int) $row['parcours_id'] : null;
    }

    private function getMaxGradesByUe(int $studentId): array
    {
        $rows = (new GradeModel())
            ->select('ue_id, MAX(note) as max_note')
            ->where('etudiant_id', $studentId)
            ->groupBy('ue_id')
            ->findAll();

        $map = [];
        foreach ($rows as $row) {
            $map[(int) $row['ue_id']] = (float) $row['max_note'];
        }

        return $map;
    }

    private function getGradeHistory(int $studentId, int $parcoursId): array
    {
        $db = Database::connect();

        return $db->table('note')
            ->select('note.id, note.note, note.created_at, ue.nom as ue_nom, semestre.numero, programme.type, programme.groupe_choix')
            ->join('ue', 'ue.id = note.ue_id')
            ->join('programme', 'programme.ue_id = ue.id')
            ->join('semestre', 'semestre.id = programme.semestre_id')
            ->where('note.etudiant_id', $studentId)
            ->where('programme.parcours_id', $parcoursId)
            ->orderBy('note.created_at', 'DESC')
            ->get()
            ->getResultArray();
    }

    private function buildSemesterSummary(string $semester, array $programmeRows, array $maxGrades, array $allNotes): array
    {
        $core = [];
        $optionalGroups = [];

        foreach ($programmeRows as $row) {
            if ($row['type'] === 'choix') {
                $group = $row['groupe_choix'] ?? 0;
                $optionalGroups[$group][] = $row;
            } else {
                $core[] = $row;
            }
        }

        $selected = $core;
        foreach ($optionalGroups as $groupRows) {
            $best = $this->pickBestOptional($groupRows, $maxGrades);
            if ($best !== null) {
                $selected[] = $best;
            }
        }

        $rows = [];
        $sum = 0.0;
        $count = 0;
        $totalCredits = 0;
        $totalCreditsObtained = 0;

        foreach ($selected as $row) {
            $ueId = (int) $row['ue_id'];
            $grade = $maxGrades[$ueId] ?? null;
            $credits = (int) $row['credits'];
            $creditsObtained = ($grade !== null && $grade >= 6) ? $credits : 0;

            if ($grade !== null) {
                $sum += $grade;
                $count++;
            }

            $totalCredits += $credits;
            $totalCreditsObtained += $creditsObtained;

            $rows[] = [
                'ue_id' => $ueId,
                'name' => $row['ue_nom'],
                'type' => $row['type'],
                'grade' => $grade,
                'credits' => $credits,
                'credits_obtained' => $creditsObtained,
                'all_notes' => $allNotes[$ueId] ?? [],
            ];
        }

        return [
            'semester' => $semester,
            'rows' => $rows,
            'average' => $count > 0 ? round($sum / $count, 2) : null,
            'optional_selected' => null,
            'total_credits' => $totalCredits,
            'total_credits_obtained' => $totalCreditsObtained,
        ];
    }

    private function pickBestOptional(array $optionalSubjects, array $maxGrades): ?array
    {
        $best = null;
        $bestGrade = -1.0;

        foreach ($optionalSubjects as $subject) {
            $subjectId = (int) $subject['ue_id'];
            $grade = $maxGrades[$subjectId] ?? null;

            if ($grade === null) {
                continue;
            }

            if ($grade > $bestGrade) {
                $bestGrade = $grade;
                $best = $subject;
            }
        }

        if ($best === null && !empty($optionalSubjects)) {
            $best = $optionalSubjects[0];
        }

        return $best;
    }

    private function computeL2Average(?float $avgS3, ?float $avgS4): ?float
    {
        if ($avgS3 === null && $avgS4 === null) {
            return null;
        }

        if ($avgS3 === null) {
            return $avgS4;
        }

        if ($avgS4 === null) {
            return $avgS3;
        }

        return round(($avgS3 + $avgS4) / 2, 2);
    }

    private function getAllNotesByUe(int $studentId): array
    {
        $rows = (new GradeModel())
            ->select('ue_id, note')
            ->where('etudiant_id', $studentId)
            ->orderBy('created_at', 'DESC')
            ->findAll();

        $map = [];
        foreach ($rows as $row) {
            $ueId = (int) $row['ue_id'];
            $map[$ueId][] = (float) $row['note'];
        }

        return $map;
    }
}
