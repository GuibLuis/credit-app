<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Consulta;
use App\Models\Oferta;
use Illuminate\Support\Facades\View;

class ConsultaController extends Controller
{
    public function store(Request $request)
    {
        $consulta = Consulta::create([
            'cpf' => $request->cpf,
        ]);

        foreach ($request->ofertas as $oferta) {
            $oferta_temp = Oferta::create([
                'id_consulta' => $consulta->id,
                'instituicao_financeira' => $oferta->instituicao_financeira,
                'modalidade_credito' => $oferta->modalidade_credito,
                'valor_a_pagar' => $oferta->valor_a_pagar,
                'valor_solicitado' => $oferta->valor_solicitado,
                'valor_parcela' => $oferta->valor_parcela,
                'taxa_juros' => $oferta->taxa_juros,
                'qnt_parcelas' => $oferta->qnt_parcelas,
            ]);
        }

        return response()->json($consulta, 201);
    }

    public function getOffers(Request $request)
    {
        $request->validate([
            'cpf' => 'required|string|size:11'
        ]);

        try {
            $response = Http::post('http://127.0.0.1:9000/consulta/', [
                'cpf' => $request->cpf
            ]);

            $offers = $response->json();
            $html = '';

            // consulta simples - sem valor e parcelas solicitado
            foreach ($offers as $instituicao => $modalidades) {
                foreach ($modalidades as $modalidade => $detalhes) {
                    $html .= View::make('components.offer_card', [
                        'instituicao' => $instituicao,
                        'modalidade' => $modalidade,
                        'qntParcelaMin' => $detalhes['QntParcelaMin'],
                        'qntParcelaMax' => $detalhes['QntParcelaMax'],
                        'valorMin' => $detalhes['valorMin'],
                        'valorMax' => $detalhes['valorMax'],
                        'jurosMes' => $detalhes['jurosMes']
                    ])->render();
                }
            }

            return response()->json(['html' => $html]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Failed to fetch offers',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
