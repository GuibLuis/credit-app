@extends('layouts.app')

@section('content')
    <div class="flex flex-col gap-16">
        <div class="flex flex-col gap-4">
            <h2>Informe o seu CPF para ver as ofertas disponíveis para você</h2>
            <div class="flex gap-2">
                <div class="relative">
                    <input type="text" id="cpf" placeholder="111.111.111-11"
                        class="border-2 border-gray-300 rounded-md p-2 w-[200px] h-full">
                    <input type="hidden" id="cpf-value" value="">
                    <p id="cpf-error" class="text-red-500 absolute -bottom-6 hidden">CPF inválido</p>
                </div>
                <button id="btn-cpf"
                    class="bg-primary text-white rounded-md py-2 px-4 hover:bg-primary/80 transition-all disabled:opacity-50 disabled:cursor-not-allowed">Ver
                    ofertas</button>
                <div id="loading" class="flex justify-center items-center opacity-0 transition-opacity duration-300 ml-4">
                    <div class="animate-spin rounded-full h-12 w-12 border-t-2 border-b-2 border-primary"></div>
                </div>
            </div>
        </div>
        <div id="offers" class="opacity-0 transition-opacity duration-300">
            <h2>Confira as ofertas disponíveis:</h2>
            <div id="offers-list" class="my-5 grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-4"></div>
            <h2>Informe o valor e a quantidade de parcelas para encontrar as três melhores opções disponíveis</h2>
            <div class="flex gap-2">
                <div class="relative">
                    <input type="text" id="valor" placeholder="1000">
                </div>
                <div class="relative">
                    <input type="text" id="parcelas" placeholder="12">
                </div>
                <button id="btn-parcelas"
                    class="bg-primary text-white rounded-md py-2 px-4 hover:bg-primary/80 transition-all disabled:opacity-50 disabled:cursor-not-allowed">Ver
                    ofertas</button>
            </div>
            <div id="best_offers-container" class="opacity-0 transition-opacity duration-300">
                <div class="flex gap-2">
                    <h3>Valor Solicitado: <span id="valor-solicitado"></span></h3>
                    <h3>Parcelas: <span id="parcelas-solicitadas"></span></h3>
                </div>
                <div id="best_offers-list" class="my-5 grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-4"></div>
            </div>
        </div>
    </div>
@endsection
