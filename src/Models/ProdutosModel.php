<?php

declare(strict_types=1);

namespace App\Models;

use PDO;
use stdClass;
use Exception;
use App\Libs\Database;

final class ProdutosModel
{
    private PDO $pdo;

    public function __construct()
    {
        $db = Database::getInstance();
        $this->pdo = $db->getPdo();
    }
    /**
     * @return stdClass[]
     */
    public function listar()
    {
        $stmt = $this->pdo->prepare("SELECT * FROM produtos ORDER BY nome");
        $stmt->execute();

        $produtos = $stmt->fetchAll(PDO::FETCH_OBJ);
        if (!$produtos) {
            return [];
        }
        return $produtos;
    }

    /**
     * @param int $id
     * @return null|stdClass
     */
    public function getProdutoById(int $id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM produtos WHERE id = :id");
        $stmt->execute([
            ':id' => $id,
        ]);

        $prodDB = $stmt->fetchObject();
        if ($prodDB) {
            return $prodDB;
        }
        return null;
    }

    public function cadastrar(stdClass $produto): int
    {
        $stmt = $this->pdo->prepare("INSERT INTO produtos (nome, cod, descricao, categoria, preco, estoque) VALUES (:nome, :cod, :descricao, :categoria, :preco, :estoque);");
        $stmt->execute([
            ':nome' => $produto->nome,
            ':cod' => $produto->cod,
            ':descricao' => $produto->descricao,
            ':categoria' => $produto->categoria,
            ':preco' => $produto->preco,
            ':estoque' => $produto->estoque,
        ]);
        $id =  $this->pdo->lastInsertId();
        if ($id) {
            return intval($id);
        }
        throw new Exception("Erro ao cadastrar produto");
    }


    public function atualizar(stdClass &$produto): stdClass
    {
        $stmt = $this->pdo->prepare("UPDATE produtos SET nome=:nome, cod=:cod, descricao=:descricao, categoria=:categoria, preco=:preco, estoque=:estoque WHERE id=:id;");
        $stmt->execute([
            ':id' => $produto->id,
            ':nome' => $produto->nome,
            ':cod' => $produto->cod,
            ':descricao' => $produto->descricao,
            ':categoria' => $produto->categoria,
            ':preco' => $produto->preco,
            ':estoque' => $produto->estoque,
        ]);

        return $produto;
    }

    public function delete(int $id)
    {
        $stmt = $this->pdo->prepare("DELETE FROM produtos WHERE  id=:id;");
        $stmt->execute([
            ':id' => $id,
        ]);
    }
}
