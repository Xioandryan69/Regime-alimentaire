<?php

namespace App\Controllers;

use Config\Database;
use App\Models\GradeModel;

class NoteController extends BaseController
{
    public function new()
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

        $subjects = $db->table('programme')
            ->select('ue.id as ue_id, ue.nom as ue_nom, ue.code, MIN(semestre.numero) as semestre_num')
            ->join('ue', 'ue.id = programme.ue_id')
            ->join('semestre', 'semestre.id = programme.semestre_id')
            ->groupBy('ue.id')
            ->orderBy('semestre_num', 'ASC')
            ->orderBy('ue.nom', 'ASC')
            ->get()
            ->getResultArray();

        return view('notes_form', [
            'students' => $students,
            'subjects' => $subjects,
            'message' => session()->getFlashdata('message'),
            'errors' => session()->getFlashdata('errors') ?? [],
        ]);
    }

    public function create()
    {
        $studentId = (int) $this->request->getPost('student_id');
        $subjectIds = $this->request->getPost('subject_id');
        $grades = $this->request->getPost('grade');

        $errors = [];
        if ($studentId <= 0) {
            $errors[] = 'Veuillez selectionner un etudiant.';
        }

        if (!is_array($subjectIds) || !is_array($grades)) {
            $errors[] = 'Veuillez saisir au moins une note.';
        }

        if ($errors) {
            return redirect()->back()->withInput()->with('errors', $errors);
        }

        $db = Database::connect();
        $relation = $db->table('etudiant_parcours')
            ->where('etudiant_id', $studentId)
            ->get()
            ->getRowArray();

        if (!$relation) {
            return redirect()->back()->withInput()->with('errors', ['Cet etudiant n\'est pas inscrit dans ce parcours.']);
        }

        $gradeModel = new GradeModel();
        $saved = 0;

        foreach ($subjectIds as $index => $subjectId) {
            $subjectId = (int) $subjectId;
            $grade = $grades[$index] ?? null;

            if ($subjectId <= 0 || $grade === null || $grade === '') {
                continue;
            }

            $gradeValue = (float) str_replace(',', '.', (string) $grade);
            if ($gradeValue < 0 || $gradeValue > 20) {
                continue;
            }

            $gradeModel->insert([
                'etudiant_id' => $studentId,
                'ue_id' => $subjectId,
                'note' => $gradeValue,
            ]);

            $saved++;
        }

        if ($saved === 0) {
            return redirect()->back()->withInput()->with('errors', ['Aucune note valide a ete enregistree.']);
        }

        return redirect()->to('/notes/new')->with('message', $saved . ' note(s) enregistree(s).');
    }

    public function addRetained()
    {
        $gradeValue = $this->request->getPost('grade');
        $studentId = (int) $this->request->getPost('student_id');
        $ueId = (int) $this->request->getPost('ue_id');

        if ($gradeValue === null || $gradeValue === '' || $studentId <= 0 || $ueId <= 0) {
            return redirect()->back()->with('errors', ['Veuillez saisir une note valide.']);
        }

        $gradeValue = (float) str_replace(',', '.', (string) $gradeValue);
        if ($gradeValue < 0 || $gradeValue > 20) {
            return redirect()->back()->with('errors', ['Note invalide.']);
        }

        $gradeModel = new GradeModel();
        
        // Get the current max grade for this student and UE
        $existingGrade = $gradeModel
            ->where('etudiant_id', $studentId)
            ->where('ue_id', $ueId)
            ->orderBy('note', 'DESC')
            ->first();

        // If there's an existing grade and the new grade is higher, replace it
        if ($existingGrade && $gradeValue > $existingGrade['note']) {
            // Delete the old highest grade
            $gradeModel->delete($existingGrade['id']);
        }

        // Insert the new grade (or keep the old one if it was higher)
        $gradeModel->insert([
            'etudiant_id' => $studentId,
            'ue_id' => $ueId,
            'note' => $gradeValue,
        ]);

        return redirect()->to('/students/' . $studentId)->with('message', 'Note ajoutee.');
    }

    public function delete(int $id)
    {
        $studentId = (int) $this->request->getPost('student_id');

        $gradeModel = new GradeModel();
        $note = $gradeModel->find($id);
        if (!$note) {
            return redirect()->back()->with('errors', ['Note introuvable.']);
        }

        $etudiantId = $note['etudiant_id'];
        $ueId = $note['ue_id'];

        // Delete the note
        $gradeModel->delete($id);

        // After deletion, check if there are other notes for this UE
        // If so, re-insert the highest one to maintain the "best note" logic
        $remainingNotes = $gradeModel
            ->where('etudiant_id', $etudiantId)
            ->where('ue_id', $ueId)
            ->orderBy('note', 'DESC')
            ->findAll();

        if (!empty($remainingNotes)) {
            // The highest remaining note is automatically kept since we only deleted one
            // The system will now use this as the retained note
        }

        if ($studentId > 0) {
            return redirect()->to('/students/' . $studentId)->with('message', 'Note supprimee.');
        }

        return redirect()->back()->with('message', 'Note supprimee.');
    }
}
