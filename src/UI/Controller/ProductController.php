<?php

declare(strict_types=1);

namespace App\UI\Controller;

use App\Application\Command\CreateProduct;
use App\Application\Command\CreateProductHandler;
use App\Application\Query\FindProductByIdHandler;
use App\Application\Query\FindProductByIdQuery;
use App\UI\Presenter\Presenter;
use App\UI\Presenter\ProductPresenter;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as FOSRest;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ProductController extends AbstractFOSRestController
{
    /**
     * @FOSRest\Post("products")
     *
     * @param Request $request
     * @param CreateProductHandler $createProductHandler
     * @return Response
     */
    public function createAction(Request $request, CreateProductHandler $createProductHandler): Response
    {
        $createProductCommand = CreateProduct::createFromRequest($request);
        $product = $createProductHandler->handle($createProductCommand);

        return $this->handleView($this->view(
            null,
            Response::HTTP_CREATED,
            ['location' => sprintf('api/products/%s', $product->getId())]
        ));
    }

    /**
     * @FOSRest\Get("products/{uuid}")
     *
     * @param string $uuid
     * @param FindProductByIdHandler $handler
     * @return Response
     */
    public function readAction(string $uuid, FindProductByIdHandler $handler): Response
    {
        $findByIdQuery = new FindProductByIdQuery($uuid);
        $productView = $handler->handle($findByIdQuery);

        return $this->handleView($this->view(
            new Presenter(new ProductPresenter($productView)),
                Response::HTTP_OK
        ));
    }
}
