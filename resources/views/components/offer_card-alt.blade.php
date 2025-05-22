@props(['order', 'instituicao', 'modalidade', 'valorAPagar', 'valorParcela', 'taxaJuros'])

<div class="offer bg-white rounded-lg shadow-lg p-6 mb-4 relative {{ $order == 1 ? 'border-2 border-primary' : '' }}">
    <h3 class="text-xl font-bold text-gray-800 mb-2">{{ $instituicao }}</h3>
    <p class="text-lg text-gray-600 mb-2 capitalize">{{ $modalidade }}</p>
    <div class="space-y-2">
        <p class="text-gray-700">
            <span class="font-semibold">Valor a pagar:</span>
            R$ {{ number_format($valorAPagar, 2, ',', '.') }}
        </p>
        <p class="text-gray-700">
            <span class="font-semibold">Valor da parcela:</span>
            R$ {{ number_format($valorParcela, 2, ',', '.') }}
        </p>
        <p class="text-gray-700">
            <span class="font-semibold">Taxa de juros:</span>
            {{ number_format($taxaJuros * 100, 2, ',', '.') }}%
        </p>
    </div>
    @if ($order == 1)
        <div class="absolute bottom-0 left-1/2 -translate-x-1/2 bg-primary text-white text-sm rounded-t-md px-2 py-1">
            <span>
                Melhor Oferta
            </span>
        </div>
    @endif
</div>
