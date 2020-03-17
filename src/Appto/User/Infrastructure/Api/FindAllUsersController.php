<?php

namespace Appto\User\Infrastructure\Api;


use Appto\Common\Infrastructure\Symfony\Messenger\QueryBus;
use Appto\User\Application\FindAllUsersQuery;
use Appto\User\Infrastructure\Api\Presenter\FindAllUserPresenter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use OpenApi\Annotations as OA;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route(
 *     "/users", name="user_"
 * )
 */
class FindAllUsersController extends AbstractController
{

    /**
     * @Route(
     *     "",
     *     methods={"GET"},
     *     name="find"
     * )
     *
     * @OA\Get(
     *     path="/",
     *     tags={"user"},
     *     summary="Find users",
     *     description="Find users",
     *     operationId="findUsers",
     *     @OA\Response(
     *          response=200,
     *          description="Success",
     *          @OA\JsonContent(
     *             type="array"
     *          )
     *     )
     * )
     */
    public function find(
        Request $request,
        QueryBus $queryBus,
        FindAllUserPresenter $presenter
    ) {
        $searchCriteria = [];
        $searchCriteria['activationLength'] = $request->query->get('activation_length');
        $searchCriteria['country'] = $request->query->get('countries');
        $searchCriteria['order'] = $request->query->get('order') ?? ['name' => 'ASC', 'lastName' => 'ASC'];

        $presenter->write(
            $queryBus->query(
                new FindAllUsersQuery(array_filter($searchCriteria))
            )
        );

        return new JsonResponse($presenter->read(), Response::HTTP_OK);

    }

}
