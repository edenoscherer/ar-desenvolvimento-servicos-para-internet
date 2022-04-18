<?PHP

use Slim\Routing\RouteCollectorProxy;
use App\Controllers\ProdutosController;

return function (\Slim\App $app) {
    $container = $app->getContainer();

    $app->group('/produtos', function (RouteCollectorProxy $group) {
        $group->get('', ProdutosController::class . ':listar');
        $group->post('', ProdutosController::class . ':novo');
        $group->put('/{id}', ProdutosController::class . ':editar');
        $group->delete('/{id}', ProdutosController::class . ':remover');
    });
};
