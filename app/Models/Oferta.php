<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Oferta extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_consulta',
        'instituicao_financeira',
        'modalidade_credito',
        'valor_a_pagar',
        'valor_solicitado',
        'valor_parcela',
        'taxa_juros',
        'qnt_parcelas',
    ];

    public $timestamps = false;
}
