$(document).ready(function () {
    // mascaras
    $("#cpf").mask("000.000.000-00");
    $("#valor").mask("000.000.000.000.000,00", {
        reverse: true,
    });
    $("#parcelas").mask("00", {
        reverse: true,
    });

    // chamada api para obter as ofertas
    function getOffers(cpf) {
        return $.ajax({
            url: "/offers",
            type: "POST",
            data: {
                cpf: cpf,
            },
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
        });
    }

    // função para renderizar as ofertas
    function renderOffers(response) {
        $("#offers-list").empty();
        if (response.html) {
            $("#offers-list").html(response.html);
        }
        $("#offers").removeClass("opacity-0");
    }

    // função para gerenciar o loading com tempo mínimo
    function withLoading(operation) {
        const loading = $("#loading");
        const button = $("#btn-cpf");
        
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

    // evento de clique do botão de cpf
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
        withLoading(getOffers(cpf))
            .then(([response]) => {
                $("#cpf-value").val(cpf);
                renderOffers(response);
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
});
