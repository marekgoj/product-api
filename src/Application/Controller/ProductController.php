<?php

declare(strict_types=1);

namespace App\Application\Controller;

use App\Application\Adapter\CreateProduct;
use App\Application\Presenter\NewProductPresenter;
use App\Application\Presenter\Presenter;
use App\Domain\UseCase\CreateProductUseCase;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as FOSRest;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ProductController extends AbstractFOSRestController
{
    /**
     * @FOSRest\Post("product")
     *
     * @param Request $request
     * @param CreateProductUseCase $createProductUseCase
     * @return Response
     */
    public function createAction(Request $request, CreateProductUseCase $createProductUseCase): Response
    {
        $createProductData = CreateProduct::createFromRequest($request);
        $product = $createProductUseCase->create($createProductData);

        return $this->handleView($this->view(new Presenter(new NewProductPresenter($product)), Response::HTTP_CREATED));
    }
}
