<?php

namespace Appto\User\Infrastructure\Api;

use Appto\Common\Infrastructure\Symfony\Messenger\QueryBus;
use Appto\User\Application\Definition\FilterDefinition;
use Appto\User\Application\Definition\SearchCriteriaDefinition;
use Appto\User\Application\FindUsersQuery;
use Appto\User\Infrastructure\Api\Presenter\FindUsersPresenter;
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
class FindUsersController extends AbstractController
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
        FindUsersPresenter $presenter
    ) {
        $filters = [];
        $filters[] = $request->query->get('activation_length')
            ? new FilterDefinition('activationLength', $request->query->get('activation_length'))
            : null;
        $filters[] = $request->query->get('countries')
        ? new FilterDefinition('country', $request->query->get('countries'))
        : null ;
        $order = $request->query->get('order') ?? ['name' => 'ASC', 'lastName' => 'ASC'];

        $presenter->write(
            $queryBus->query(
                new FindUsersQuery(
                    new SearchCriteriaDefinition(array_filter($filters), $order)
                )
            )
        );

        return new JsonResponse($presenter->read(), Response::HTTP_OK);

    }

}
