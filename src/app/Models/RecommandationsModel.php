<?php

namespace App\Models;

use CodeIgniter\Model;

class RecommendationModel extends Model
{
    protected $table = 'recommendations';

    protected $primaryKey = 'id';

    protected $returnType = 'array';

    protected $allowedFields = [
        'user_id',
        'regime_id',
        'activite_id',
        'date_debut',
        'date_fin'
    ];

    /**
     * Validation
     */
    protected $validationRules = [

        'user_id' => 'required|integer',

        'regime_id' => 'required|integer',

        'activite_id' => 'permit_empty|integer',

        'date_debut' => 'required|valid_date',

        'date_fin' => 'required|valid_date'
    ];

    /**
     * Enregistrer recommandations utilisateur
     */
    public function enregistrer(
        int $user_id,
        array $regimes,
        array $activites = []
    ): bool {

        // supprimer anciennes recommandations
        $this->where('user_id', $user_id)->delete();

        $date_debut = date('Y-m-d');

        foreach ($regimes as $index => $regime) {

            $activite = null;

            // rotation activités
            if (!empty($activites)) {

                $activite =
                    $activites[
                        $index % count($activites)
                    ];
            }

            // durée du régime
            $duree =
                $regime['duree_jours'] ?? 30;

            $date_fin = date(
                'Y-m-d',
                strtotime("+{$duree} days")
            );

            $this->insert([

                'user_id' => $user_id,

                'regime_id' =>
                    $regime['id'],

                'activite_id' =>
                    $activite['id'] ?? null,

                'date_debut' =>
                    $date_debut,

                'date_fin' =>
                    $date_fin
            ]);
        }

        return true;
    }

    /**
     * Recommandations détaillées utilisateur
     */
    public function getAvecDetails(
        int $user_id
    ): array {

        return $this->db
            ->table('recommendations rec')

            ->select('
                rec.id,
                rec.date_debut,
                rec.date_fin,

                r.id AS regime_id,
                r.nom AS regime_nom,
                r.description AS regime_description,
                r.calories,
                r.prix,
                r.duree_jours,

                tr.nom AS type_regime,

                a.id AS activite_id,
                a.nom AS activite_nom,
                a.description AS activite_description,
                a.calories_brulees,
                a.duree_minutes
            ')

            ->join(
                'regimes r',
                'r.id = rec.regime_id',
                'left'
            )

            ->join(
                'type_regimes tr',
                'tr.id = r.type_regime_id',
                'left'
            )

            ->join(
                'activites a',
                'a.id = rec.activite_id',
                'left'
            )

            ->where('rec.user_id', $user_id)

            ->orderBy(
                'rec.date_debut',
                'DESC'
            )

            ->get()

            ->getResultArray();
    }

    /**
     * Supprimer recommandations utilisateur
     */
    public function supprimerParUser(
        int $user_id
    ): bool {

        return $this
            ->where('user_id', $user_id)
            ->delete();
    }

    /**
     * Recommandations actives
     */
    public function getActives(
        int $user_id
    ): array {

        $today = date('Y-m-d');

        return $this->where(
                'user_id',
                $user_id
            )

            ->where(
                'date_fin >=',
                $today
            )

            ->findAll();
    }
}