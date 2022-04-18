<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Libs\BaseController;
use App\Libs\HttpStatusCode;
use App\Models\ProdutosModel;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use stdClass;

final class ProdutosController extends BaseController
{

    public function listar(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $model = new ProdutosModel();
        $produtos = $model->listar();
        return $this->renderJson($response, $produtos);
    }


    public function novo(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        try {
            $data = (object)$request->getParsedBody();
            $model = new ProdutosModel();
            $id = $model->cadastrar($data);
            if ($id > 0) {
                return $this->renderJson($response, $model->getProdutoById($id), HttpStatusCode::HTTP_CREATED);
            }
            return $this->renderJson($response, ['msg' => 'Erro ao cadastrar produto'], HttpStatusCode::HTTP_BAD_REQUEST);
        } catch (\Throwable $th) {
            return $this->renderJson($response, ['msg' => 'Erro ao cadastrar produto', 'error' => $th->getMessage()], HttpStatusCode::HTTP_BAD_REQUEST);
        }
    }

    public function editar(ServerRequestInterface $request, ResponseInterface $response, $args = []): ResponseInterface
    {
        try {
            $id = intval($args['id']);
            $data = (object)$request->getParsedBody();
            $data->id = $id;
            $model = new ProdutosModel();
            $model->atualizar($data);
            return $this->renderJson($response, $model->getProdutoById($id), HttpStatusCode::HTTP_ACCEPTED);
        } catch (\Throwable $th) {
            return $this->renderJson($response, ['msg' => 'Erro ao atualizar produto', 'error' => $th->getMessage()], HttpStatusCode::HTTP_BAD_REQUEST);
        }
    }

    public function remover(ServerRequestInterface $request, ResponseInterface $response, $args = []): ResponseInterface
    {
        try {
            $id = intval($args['id']);
            $model = new ProdutosModel();
            $produto = $model->getProdutoById($id);
            $model->delete($id);
            return $this->renderJson($response, $produto, HttpStatusCode::HTTP_CREATED);
        } catch (\Throwable $th) {
            return $this->renderJson($response, ['msg' => 'Erro ao atualizar produto', 'error' => $th->getMessage()], HttpStatusCode::HTTP_BAD_REQUEST);
        }
    }
}
