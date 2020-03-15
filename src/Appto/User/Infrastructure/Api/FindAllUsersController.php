<?php

namespace Appto\User\Infrastructure\Api;


use Appto\User\Application\FindAllUsersQuery;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use OpenApi\Annotations as OA;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
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
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/User")
     *          )
     *     )
     * )
     */
    public function find(
        Request $request,
        MessageBusInterface $queryBus
    ) {

        $users =  $queryBus->dispatch(
            new FindAllUsersQuery()
        );

        return new JsonResponse($users, Response::HTTP_OK);

    }

}
