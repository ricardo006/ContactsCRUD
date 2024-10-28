<?php 
    include('navbar.php');
    include 'api.php'; 
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Criar Pessoa</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
</head>
<body>
    <div class="container mt-5">
        <a href="index.php" class="btn btn-secondary btn-voltar">
            <i class="bi bi-arrow-left"></i>
            &nbsp;Voltar
        </a>
        <h5 class="mt-4">Cadastro de Pessoa</h5>
        <form id="createPersonForm">
            <div class="form-group">
                <label for="nome">Nome:</label>
                <input type="text" class="form-control" id="nome" name="nome" required>
            </div>

            <div class="form-group">
                <label for="idade">Idade:</label>
                <input type="number" class="form-control" id="idade" name="idade" min="1" required oninput="this.setCustomValidity(this.validity.rangeUnderflow ? 'Por favor, insira um valor acima de 0.' : '');">
                <div class="invalid-feedback">Por favor, insira uma idade válida acima de 0.</div>
            </div>

            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>

            <h3>Contatos:</h3>
            <div id="contacts">
                <div class="contact form-group row align-items-end mb-3">
                    <div class="col-md-5">
                        <label for="tipo">Tipo:</label>
                        <select class="form-control" name="contacts[0][type]" required>
                            <option value="">Selecione um tipo</option>
                            <?php
                            // Função que retorna os tipos - em api.php
                            $tipos = getTypes();
                            foreach ($tipos as $tipo) {
                                echo "<option value='{$tipo->type}'>{$tipo->type}</option>"; // Acessando 'type'
                            }
                            ?>
                        </select>
                    </div>

                    <div class="col-md-5">
                        <label for="valor">Valor:</label>
                        <input type="text" class="form-control" name="contacts[0][value]" required>
                    </div>
                    <div class="col-md-2 text-right">
                        <button type="button" class="btn btn-danger shadow removeContact">
                            <i class="bi bi-trash3"></i>     
                            &nbsp; Excluir
                        </button>
                    </div>
                </div>
            </div>
            <button type="button" class="btn btn-primary" id="addContact">
                <i class="bi bi-person-circle"></i>
                &nbsp; Novo Contato
            </button>
            <button type="submit" class="btn btn-success shadow">
                <i class="bi bi-plus-circle"></i>
                &nbsp; Cadastrar
            </button>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.0.7/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script>
        let contactIndex = 1;

        // Função para adicionar novos contatos
        $('#addContact').on('click', function() {
            const newContact = `
                <div class="contact form-group row align-items-end mb-3">
                    <div class="col-md-5">
                        <label for="tipo">Tipo:</label>
                        <select class="form-control" name="contacts[${contactIndex}][type]" required>
                            <option value="">Selecione um tipo</option>
                            <?php
                            foreach ($tipos as $tipo) {
                                echo "<option value='{$tipo->type}'>{$tipo->type}</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-md-5">
                        <label for="valor">Valor:</label>
                        <input type="text" class="form-control" name="contacts[${contactIndex}][value]" required>
                    </div>
                    <div class="col-md-2 text-right">
                        <button type="button" class="btn btn-danger shadow removeContact"><i class="bi bi-trash"></i> &nbsp; Excluir</button>
                    </div>
                </div>
            `;
            $('#contacts').append(newContact);
            contactIndex++;
        });

        // Evento para remover um contato
        $(document).on('click', '.removeContact', function() {
            $(this).closest('.contact').remove();
        });

        // Manipulação do envio do formulário
        $('#createPersonForm').on('submit', function(event) {
            event.preventDefault();

            let formData = $(this).serializeArray();
            let data = {};
            formData.forEach(function(item) {
                if (item.name.startsWith('contacts')) {
                    const contactIndex = item.name.match(/\[(.*?)\]/)[1];
                    if (!data.contacts) {
                        data.contacts = [];
                    }
                    if (!data.contacts[contactIndex]) {
                        data.contacts[contactIndex] = {};
                    }
                    data.contacts[contactIndex][item.name.split('[')[2].split(']')[0]] = item.value;
                } else {
                    data[item.name] = item.value;
                }
            });

            // Enviando a requisição para a API
            $.ajax({
                url: 'http://localhost:8000/api/people',
                method: 'POST',
                contentType: 'application/json',
                data: JSON.stringify(data),
                success: function(response) {
                    alert('Pessoa criada com sucesso!');
                    console.log(response);
                    // Limpa o formulário após o sucesso
                    $('#createPersonForm')[0].reset();
                    $('#contacts').empty().append(`
                        <div class="contact form-group row align-items-end mb-3">
                            <div class="col-md-5">
                                <label for="tipo">Tipo:</label>
                                <select class="form-control" name="contacts[0][type]" required>
                                    <option value="">Selecione um tipo</option>
                                    <?php
                                    foreach ($tipos as $tipo) {
                                        echo "<option value='{$tipo->type}'>{$tipo->type}</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-md-5">
                                <label for="valor">Valor:</label>
                                <input type="text" class="form-control" name="contacts[0][value]" required>
                            </div>
                            <div class="col-md-2 text-right">
                                <button type="button" class="btn btn-danger removeContact">Excluir</button>
                            </div>
                        </div>
                    `);
                },
                error: function(xhr, status, error) {
                    alert('Erro ao criar pessoa: ' + error);
                    // Exibindo
                    console.log(xhr.responseText);
                }
            });
        });
    </script>
</body>
</html>
