<?php 
    //Cabeçalhos para o arquivo JSON
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    //Inclui conexao com o banco de dados
    include_once 'conn.php';
    switch ($_SERVER['REQUEST_METHOD']) {
        case 'GET':
            $sql = "SELECT id, titulo, categoria, texto, data, status, imagem FROM artigos ORDER BY id DESC";
            $stmt = $pdo->prepare($sql);
            $stmt->execute();
            //Verifica se a consulta retornou algum registro
            if(($stmt) AND ($stmt->rowCount() != 0)){
                while($row_artigo = $stmt->fetch(PDO::FETCH_ASSOC)){
                    extract($row_artigo);
                    $lista_artigos["records"][$id] = [
                        'id' => $id,
                        'titulo' => $titulo,
                        'categoria' => $categoria,
                        'texto' => $texto,
                        'data' => $data,
                        'status' => $status,
                        'imagem' => $imagem
                    ];
                }
                //Resposta com status 200
                http_response_code(200);
                //Retorna os artigos em formato JSON
                echo json_encode($lista_artigos);
            }
        break;
        case 'POST':
            $titulo = $_POST['titulo'];
            $categoria = $_POST['categoria'];
            $texto = $_POST['texto'];
            $data = date('Y-m-d H:i:s');
            $status = $_POST['status'];
            $imagem = $_FILES['imagem'];
            if ($imagem['name']) {
                $extensao = strtolower(substr($imagem['name'], -4));
                $novo_nome = md5(time()) . $extensao;
                $diretorio = "upload/";
                move_uploaded_file($imagem['tmp_name'], $diretorio . $novo_nome);
            }
            //insert
            $sql = "INSERT INTO artigos (titulo, categoria, texto, data, status, imagem) VALUES (titulo, categoria, texto, data, :status, :imagem)";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':titulo', $titulo);
            $stmt->bindParam(':categoria', $categoria);
            $stmt->bindParam(':texto', $texto);
            $stmt->bindParam(':data', $data);
            $stmt->bindParam(':status', $status);
            $stmt->bindParam(':imagem', $novo_nome);
            $stmt->execute();
            if ($stmt->rowCount() > 0) {
                echo json_encode(array('sucesso' => 'Artigo inserido com sucesso'));
            } else {
                echo json_encode(array('erro' => 'Erro ao inserir artigo'));
            }
        break;       
        case 'DELETE':
            $id = $_GET['id'];
            $query = $pdo->prepare("DELETE FROM artigos WHERE id = :id");
            $query->execute([
                ':id' => $id
            ]);
            http_response_code(200);
            echo json_encode([
                'status' => 'success',
                'message' => 'Artigo deletado com sucesso!'
            ]);
        break;       
    }
