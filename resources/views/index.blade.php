@extends('layouts.app')

@section('content')
    <div class="flex flex-col gap-16 mb-28">
        <div class="flex flex-col gap-4">
            <h2>Informe o seu CPF para ver as ofertas disponíveis para você.</h2>
            <div class="flex gap-2">
                @include('components.input', [
                    'id' => 'cpf',
                    'placeholder' => '111.111.111-11',
                ])
                @include('components.btn', ['id' => 'btn-cpf', 'text' => 'Ver ofertas'])
                <div id="loading" class="flex justify-center items-center opacity-0 transition-opacity duration-300 ml-4">
                    <div class="animate-spin rounded-full h-12 w-12 border-t-2 border-b-2 border-primary"></div>
                </div>
            </div>
        </div>
        <div id="offers" class="opacity-0 transition-opacity duration-300">
            <h2>Confira as ofertas disponíveis:</h2>
            <div id="offers-list" class="mt-5 mb-16 grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-4"></div>
            <div class="flex flex-col gap-4">
                <h2 class="w-[600px]">Informe o valor e a quantidade de parcelas desejadas para encontrar as suas três
                    melhores
                    opções.</h2>
                <div class="flex gap-2">
                    <div class="relative">
                        @include('components.input', [
                            'id' => 'valor',
                            'placeholder' => '1.000,00',
                            'class' => 'ml-8',
                        ])
                        <div id="valor-prefix"
                            class="absolute top-0 left-0 bg-white rounded-l-md px-2 h-full flex items-center border-2 border-r-0 border-gray-300">
                            <span class="font-bold text-gray-500">R$</span></div>
                    </div>
                    @include('components.input', [
                        'id' => 'parcelas',
                        'placeholder' => '12',
                        'class' => 'w-[100px]',
                    ])
                    @include('components.btn', ['id' => 'btn-parcelas', 'text' => 'Buscar'])
                    <div id="loading"
                        class="flex justify-center items-center opacity-0 transition-opacity duration-300 ml-4">
                        <div class="animate-spin rounded-full h-12 w-12 border-t-2 border-b-2 border-primary"></div>
                    </div>
                </div>
            </div>
            <div id="best_offers-container" class="opacity-0 mt-10 transition-opacity duration-300">
                <div class="flex gap-6">
                    <h3>Valor Solicitado: <span id="valor-solicitado"></span></h3>
                    <h3>Parcelas: <span id="parcelas-solicitadas"></span></h3>
                </div>
                <div id="best_offers-list" class="my-5 grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-4"></div>
            </div>
        </div>
    </div>
@endsection
