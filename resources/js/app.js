$(document).ready(function () {
    // mascaras
    $("#cpf").mask("000.000.000-00");
    $("#valor").mask("000.000.000.000.000,00", {
        reverse: true,
    });
    $("#parcelas").mask("00", {
        reverse: true,
    });

    // função para guardar as consultas no banco
    function saveConsult(cpf, offers) {
        return $.ajax({
            url: "/store-consult",
            type: "POST",
            data: {
                cpf: cpf,
                offers: offers,
            },
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
        });
    }
    

    // chamada api para obter as ofertas
    function getOffers(cpf, valor, parcelas) {
        return $.ajax({
            url: "/offers",
            type: "POST",
            data: {
                cpf: cpf,
                valor: valor,
                parcelas: parcelas,
            },
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
        });
    }

    // função para renderizar as ofertas
    function renderOffers(responseHtml, listId, containerId) {
        $(listId).empty();
        if (responseHtml) {
            $(listId).html(responseHtml);
        }
        $(containerId).removeClass("opacity-0");
    }

    // função para gerenciar o loading com tempo mínimo
    function withLoading(operation) {
        const loading = $("#loading");
        const button = $("#btn-cpf, #btn-parcelas");
        
        // Mostra o loading e desabilita o botão
        loading.removeClass("opacity-0");
        button.prop("disabled", true);

        // Cria uma promise que resolve após 1 segundo
        const minimumLoadingTime = new Promise(resolve => setTimeout(resolve, 1000));

        // Executa a operação e espera tanto a operação quanto o tempo mínimo
        return Promise.all([
            operation,
            minimumLoadingTime
        ]).finally(() => {
            // Esconde o loading e habilita o botão
            loading.addClass("opacity-0");
            button.prop("disabled", false);
        });
    }

    // evento de clique do botão 'form' de cpf
    $("#btn-cpf").click(function () {
        // erro de 'cpf' ao enviar um valor inválido
        var cpf = $("#cpf").val().replace(/[.-]/g, "");
        if (cpf.length != 11) {
            $("#cpf-error").removeClass("hidden");
            $("#cpf").addClass("border-red-500");
            return;
        }
        // limpa a lista de ofertas e esconde a lista para a proxima chamada
        $("#offers-list").empty();
        $("#offers").addClass("opacity-0");
        // Usa o withLoading para envolver a chamada da API
        withLoading(getOffers(cpf, 0, 0))
            .then(([response]) => {
                $("#cpf-value").val(cpf);
                renderOffers(response.html, "#offers-list", "#offers");
            })
            .catch(error => {
                console.error("Error fetching offers:", error);
            });
    });

    // desativa o 'erro' apenas ao digitar um 'cpf' completo
    $("#cpf").on("keyup", function () {
        if ($(this).val().length == 14) {
            $("#cpf-error").addClass("hidden");
            $(this).removeClass("border-red-500");
        }
    });
    // desativa o 'erro' apenas ao digitar um 'valor' completo
    $("#valor").on("keyup", function () {
        $("#valor-error").addClass("hidden");
        $(this).removeClass("border-red-500");
        $("#valor-prefix").removeClass("border-red-500");
    });
    // desativa o 'erro' apenas ao digitar um 'parcelas' completo
    $("#parcelas").on("keyup", function () {
        $("#parcelas-error").addClass("hidden");
        $(this).removeClass("border-red-500");
    });

    // evento de clique do 'form' de valor e parcelas
    $("#btn-parcelas").click(function () {
        // erro de 'cpf' ao enviar um valor inválido
        var cpf = $("#cpf-value").val();
        var valorOld = $("#valor").val();
        var valor = valorOld.replace(/[.]/g, "").replace(/[,]/, ".");
        var parcelas = $("#parcelas").val();
        
        if (cpf.length != 11 || valor == '' || parcelas == '') {
            $("#valor-error").removeClass("hidden");
            $("#valor").addClass("border-red-500");
            $("#valor-prefix").addClass("border-red-500");
            $("#parcelas-error").removeClass("hidden");
            $("#parcelas").addClass("border-red-500");
            return;
        }
        
        // Usa o withLoading para envolver a chamada da API
        withLoading(getOffers(cpf, valor, parcelas))
            .then(([response]) => {
                console.log(response);
                $("#valor-solicitado").text('R$ ' + valorOld);
                $("#parcelas-solicitadas").text(parcelas);
                renderOffers(response.html, "#best_offers-list", "#best_offers-container");
                saveConsult(cpf, response.offers)
                    .catch(error => {
                        console.error("Error saving consult:", error);
                    });
            })
            .catch(error => {
                console.error("Error fetching best offers:", error);
            });
    });
});
