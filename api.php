<?php 

define('API_URL', 'http://localhost:8000/api');

function callAPI($method, $endpoint, $data = false) {
    $url = API_URL . $endpoint;
    $options = [
        'http' => [
            'header' => "Content-Type: application/json\r\n",
            'method' => $method,
        ],
    ];

    if ($data) {
        $options['http']['content'] = json_encode($data);
    }

    $context = stream_context_create($options);
    $response = @file_get_contents($url, false, $context);

    if ($response === false) {
        throw new Exception("Erro ao chamar a API: " . print_r($http_response_header, true));
    }

    return json_decode($response);
}

// Obter todas as pessoas
function getAllPeople() {
    return callAPI('GET', '/people');
}

// Criar uma nova pessoa
function createPerson($data) {
    return callAPI('POST', '/people', $data);
}

function deletePeople() {
    return callAPI('DELETE', "people/{$id}");
}

function editPerson() {
    return callAPI('PUT', "people/{$id}");
}

// Obter tipos
function getTypes() {
    return callAPI('GET', '/types');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $json = file_get_contents('php://input');
    $data = json_decode($json, true);

    $response = createPerson($data);

    header('Content-Type: application/json');
    echo json_encode($response);
    exit;
}

?>
