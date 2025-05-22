@props(['instituicao', 'modalidade', 'qntParcelaMin', 'qntParcelaMax', 'valorMin', 'valorMax', 'jurosMes'])

<div class="offer bg-white rounded-lg shadow-lg p-6 mb-4">
    <h3 class="text-xl font-bold text-gray-800 mb-2">{{ $instituicao }}</h3>
    <p class="text-lg text-gray-600 mb-2 capitalize">{{ $modalidade }}</p>
    <div class="space-y-2">
        <p class="text-gray-700">
            <span class="font-semibold">Parcelas:</span>
            De {{ $qntParcelaMin }} a {{ $qntParcelaMax }} meses
        </p>
        <p class="text-gray-700">
            <span class="font-semibold">Valor Mínimo:</span>
            R$ {{ number_format($valorMin, 2, ',', '.') }}
        </p>
        <p class="text-gray-700">
            <span class="font-semibold">Valor Máximo:</span>
            R$ {{ number_format($valorMax, 2, ',', '.') }}
        </p>
        <p class="text-gray-700">
            <span class="font-semibold">Juros:</span>
            {{ number_format($jurosMes * 100, 2, ',', '.') }}%
        </p>
    </div>
</div>
