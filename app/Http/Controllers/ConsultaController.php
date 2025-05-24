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
        $request->validate([
            'cpf' => 'required|string|size:11',
            'offers' => 'nullable|array'
        ]);

        $consulta = Consulta::create([
            'cpf' => $request->cpf,
        ]);

        if ($request->offers) {
            foreach ($request->offers as $oferta) {
                $oferta_temp = Oferta::create([
                    'id_consulta' => $consulta->id,
                    'instituicao_financeira' => $oferta['instituicaoFinanceira'],
                    'modalidade_credito' => $oferta['modalidadeCredito'],
                    'valor_a_pagar' => $oferta['valorAPagar'],
                    'valor_solicitado' => $oferta['valorSolicitado'],
                    'valor_parcela' => $oferta['valorParcela'],
                    'taxa_juros' => $oferta['taxaJuros'],
                    'qnt_parcelas' => $oferta['qntParcelas'],
                ]);
            }
        }

        return response()->json($consulta, 201);
    }

    public function getOffers(Request $request)
    {
        $request->validate([
            'cpf' => 'required|string|size:11',
            'valor' => 'nullable|numeric',
            'parcelas' => 'nullable|numeric'
        ]);

        //main = http://127.0.0.1:9000/consulta/
        //mockup = http://127.0.0.1:9000/mockup_data/
        try {
            $valor = $request->valor ?? 0;
            $parcelas = $request->parcelas ?? 0;

            $response = Http::post('http://127.0.0.1:9000/consulta/', [
                'cpf' => $request->cpf,
                'valorSolicitado' => $valor,
                'parcelas' => $parcelas
            ]);

            $offers = $response->json();
            $html = '';

            // consulta simples - sem valor e parcelas solicitado
            if ($valor == 0 && $parcelas == 0) {
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
            } else {
                foreach ($offers as $order => $offer) {
                    $html .= View::make('components.offer_card-alt', [
                        'order' => $order,
                        'instituicao' => $offer['instituicaoFinanceira'],
                        'modalidade' => $offer['modalidadeCredito'],
                        'valorAPagar' => $offer['valorAPagar'],
                        'valorParcela' => $offer['valorParcela'],
                        'taxaJuros' => $offer['taxaJuros'],
                    ])->render();
                }
            }

            return response()->json(['html' => $html, 'offers' => $offers]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Failed to fetch offers',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
