<?php

namespace App\Models;

use CodeIgniter\Model;

class FactLiv extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'fact_liv';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'id_client',
        'consignataire',
        'amendement',
        'bl',
        'compagnie',
        'reglement',
        'paiement',
        'date_paiement',
        'date_creation',
        'preget',
        'date_pg',
        'annulation',
        'motif',
        'id',
        'ages',
        'copie',
        'hammar',
        'avec_tva',
        'avec_ages',
        'avec_copie',
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];
}
