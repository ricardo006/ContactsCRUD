<?php 
require_once 'navbar.php';
require_once 'api.php';

try {
    $people = getAllPeople(); 
    $tipos = getTypes(); 

    ?>
    <!DOCTYPE html>
    <html lang="pt-BR">
        <head>
            <meta charset="UTF-8">
            <title>Lista de Pessoas</title>
            <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
            <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
            <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
            <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
            <style>
                .table th, .table td {
                    vertical-align: middle;
                }

                .btn-danger:hover {
                    background-color: #c82333;
                    color: white;
                }

                .modal-confirm {
                    display: none;
                }

                .content {
                    padding: 20px;
                    border-radius: 20px;
                    margin-top: 10px;
                    background: #fbfaff;
                }

                .content:hover {
                    box-shadow: rgba(0, 0, 0, 0.24) 0px 3px 8px;
                }

                .content table {
                    color: #263238;
                }

                .content table thead tr {
                    color: #293241;
                }

                .btn-danger span.text-span {
                    font-size: 16px;
                }
            </style>
        </head>
        <body>
            <div class="container content">
                <div class="message-info"></div>
                <h5>Lista de Pessoas</h5>
                <?php if (!empty($people) && is_array($people)): ?>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Nome</th>
                                <th>Idade</th>
                                <th>Email</th>
                                <th>Contatos</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($people as $person): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($person->nome); ?></td>
                                    <td><?php echo htmlspecialchars($person->idade); ?></td>
                                    <td><?php echo htmlspecialchars($person->email); ?></td>
                                    <td>
                                        <?php 
                                            if (!empty($person->contacts) && is_array($person->contacts)) {
                                                foreach ($person->contacts as $contact) {
                                                    echo htmlspecialchars($contact->type) . ": " . htmlspecialchars($contact->value) . "<br>";
                                                }
                                            } else {
                                                echo "Sem contatos";
                                            }
                                        ?>
                                    </td>
                                    <td>
                                        <button class="btn btn-info shadow editPerson" data-id="<?= $person->id ?>" data-nome="<?= htmlspecialchars($person->nome) ?>" data-idade="<?= htmlspecialchars($person->idade) ?>" data-email="<?= htmlspecialchars($person->email) ?>" data-contacts='<?= htmlspecialchars(json_encode($person->contacts)) ?>'>
                                            <i class="bi bi-pencil"></i>   
                                            &nbsp;Editar
                                        </button>

                                        <button class="btn btn-danger shadow deletePerson" data-id="<?= $person->id ?>">
                                            <i class="bi bi-trash"></i>     
                                            &nbsp;Excluir
                                        </button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <div class="alert alert-warning" role="alert">
                        Nenhuma pessoa encontrada.
                    </div>
                <?php endif; ?>
            </div>

            <!-- Modal de Edição -->
            <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editModalLabel">Editar Pessoa</h5>
                        </div>

                        <div class="modal-body">
                            <form id="editForm">
                                <div class="form-group">
                                    <label for="nome">Nome:</label>
                                    <input type="text" class="form-control" id="nome" name="nome" required>
                                </div>
                                <div class="form-group">
                                    <label for="idade">Idade:</label>
                                    <input type="number" class="form-control" id="idade" name="idade" required min="1">
                                </div>
                                <div class="form-group">
                                    <label for="email">Email:</label>
                                    <input type="email" class="form-control" id="email" name="email" required>
                                </div>
                                <div id="contactsContainer">
                                    <!-- Contatos serão carregados aqui -->
                                </div>
                                <button type="button" class="btn btn-secondary" id="addContact">Adicionar Contato</button>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                            <button type="submit" class="btn btn-primary" id="saveChanges">Salvar mudanças</button>
                        </div>
                    </div>
                </div>
            </div>

        </body>
        <script>
            let contactIndex = 0;

            // Abrir o modal e preencher os dados
            $(document).on('click', '.editPerson', function() {
                const id = $(this).data('id');
                const nome = $(this).data('nome');
                const idade = $(this).data('idade');
                const email = $(this).data('email');
                const contacts = $(this).data('contacts');

                // Limpar e preencher os campos do modal
                $('#nome').val(nome);
                $('#idade').val(idade);
                $('#email').val(email);
                $('#contactsContainer').empty();
                contactIndex = 0; // Resetar o index quando abrir o modal

                // Preencher os contatos existentes no modal
                contacts.forEach(contact => {
                    const contactHtml = `
                        <div class="contact form-group row align-items-end mb-3">
                            <div class="col-md-5">
                                <label for="tipo">Tipo:</label>
                                <select class="form-control" name="contacts[${contactIndex}][type]" required>
                                    <option value="">Selecione um tipo</option>
                                    <?php foreach ($tipos as $tipo): ?>
                                        <option value="<?= htmlspecialchars($tipo->type) ?>" ${contact.type === '<?= htmlspecialchars($tipo->type) ?>' ? 'selected' : ''}><?= htmlspecialchars($tipo->type) ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-md-5">
                                <label for="valor">Valor:</label>
                                <input type="text" class="form-control" name="contacts[${contactIndex}][value]" required value="${contact.value}">
                            </div>
                            <div class="col-md-2 text-right">
                                <button type="button" class="btn btn-danger shadow removeContact" tooltip="Remover linha"><i class="bi bi-trash"></i></button>
                            </div>
                        </div>
                    `;
                    $('#contactsContainer').append(contactHtml);
                    contactIndex++;
                });

                // Mostrar o modal
                $('#editModal').modal('show');
                $('#saveChanges').data('id', id); // Guardar o ID da pessoa atual
            });

            // Adicionar um novo contato
            $('#addContact').on('click', function() {
                const newContact = `
                    <div class="contact form-group row align-items-end mb-3">
                        <div class="col-md-5">
                            <label for="tipo">Tipo:</label>
                            <select class="form-control" name="contacts[${contactIndex}][type]" required>
                                <option value="">Selecione um tipo</option>
                                <?php foreach ($tipos as $tipo): ?>
                                    <option value="<?= htmlspecialchars($tipo->type) ?>"><?= htmlspecialchars($tipo->type) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-5">
                            <label for="valor">Valor:</label>
                            <input type="text" class="form-control" name="contacts[${contactIndex}][value]" required>
                        </div>
                        <div class="col-md-2 text-right">
                            <button type="button" class="btn btn-danger shadow removeContact" tooltip="Remover linha"><i class="bi bi-trash"></i></button>
                        </div>
                    </div>
                `;
                $('#contactsContainer').append(newContact);
                contactIndex++;
            });

            // Remover contato
            $(document).on('click', '.removeContact', function() {
                $(this).closest('.contact').remove();
            });

            // Salvar alterações
            $('#saveChanges').on('click', function() {
                const currentPersonId = $(this).data('id'); // Pegar o ID da pessoa atual
                const formData = $('#editForm').serializeArray();
                const data = {
                    id: currentPersonId, 
                    contacts: []
                };

                // Converte o array de dados em um objeto
                formData.forEach(item => {
                    // Se o campo for um contato
                    if (item.name.startsWith('contacts[')) {
                        const match = item.name.match(/contacts\[(\d+)\]\[(\w+)\]/);
                        if (match) {
                            const index = match[1]; 
                            const type = match[2];

                            if (!data.contacts[index]) {
                                data.contacts[index] = {};
                            }
                            data.contacts[index][type] = item.value; 
                        }
                    } else {
                        data[item.name] = item.value;
                    }
                });

                // Log para verificar a estrutura dos dados
                console.log('Dados que serão enviados:', JSON.stringify(data));

                $.ajax({
                    type: 'PUT',
                    url: `http://localhost:8000/api/people/${currentPersonId}`, 
                    data: JSON.stringify(data),
                    contentType: 'application/json',
                    success: function(response) {
                        location.reload(); 
                    },
                    error: function() {
                        alert('Erro ao salvar as alterações. Tente novamente.');
                    }
                });
            });

            // Deletar pessoa
            $(document).on('click', '.deletePerson', function() {
                const id = $(this).data('id');
                if (confirm('Tem certeza de que deseja excluir esta pessoa?')) {
                    $.ajax({
                        type: 'DELETE',
                        url: `http://localhost:8000/api/people/${id}`, 
                        success: function(response) {
                            const message = $('<div class="alert alert-success">Pessoa excluída com sucesso!</div>');
                            $('.message-info').append(message);

                            setTimeout(function() {
                            message.fadeOut(function() {
                                $(this).remove(); 
                            });

                            location.reload(); 
                        }, 3000);

                        },
                        error: function() {
                            alert('Erro ao excluir a pessoa. Tente novamente.');
                        }
                    });
                }
            });
        </script>
    </html>
    <?php
} catch (Exception $e) {
    echo 'Erro: ' . htmlspecialchars($e->getMessage());
}
?>
