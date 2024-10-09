$(document).ready(function() {
   $("#agendamentoForm").submit(function(e) {
    e.preventDefault();

    var formData = new FormData(this);

    $.ajax({
        url: 'index.php',
        type: 'POST',
        data: formData,
        contentType: false,
            processData: false,
            success: function (response) {
                $('#mensagem').html(response); // Mostra a resposta na div com id "mensagem"
            },
            error: function () {
                $('#mensagem').html('<p style="color:red;">Erro ao enviar o formulário.</p>');
            }
        });
    });
}); 