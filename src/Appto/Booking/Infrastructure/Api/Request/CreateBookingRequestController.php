<?php

namespace Appto\Booking\Infrastructure\Api\Request;

use Appto\Booking\Application\Request\CreateBookingRequestCommand;
use Appto\Booking\Application\Request\Definition\PriceDefinition;
use Appto\Booking\Application\Request\Definition\RequesterDefinition;
use Appto\Booking\Application\Request\Definition\RequestViewDefinition;
use Appto\Booking\Domain\Request\BookingRequestRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use OpenApi\Annotations as OA;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route(
 *     "/requests", name="request_"
 * )
 */
class CreateBookingRequestController extends AbstractController
{

    /**
     * @Route(
     *     "",
     *     methods={"POST"},
     *     name="create"
     * )
     *
     * @OA\Post(
     *     path="/requests",
     *     tags={"request"},
     *     summary="Create request",
     *     description="Create request",
     *     operationId="addRequest",
     *     @OA\Response(
     *          response=200,
     *          description="Success",
     *          @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/RequestViewDefinition")
     *          )
     *     ),
     *     @OA\RequestBody(
     *          request="Request",
     *          description="Request object",
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/RequestDefinition")
     *      )
     * )
     */
    public function create(
        Request $request,
        MessageBusInterface $commandBus,
        BookingRequestRepository $bookingRequestRepository
    ) {

        $body = json_decode((string)$request->getContent());

        $commandBus->dispatch(
            new CreateBookingRequestCommand(
                $body->id,
                $body->boatId,
                $body->portId,
                $body->numberOfPassengers,
                \DateTime::createFromFormat('d-m-Y', $body->startDate)->setTime(0,0,0),
                \DateTime::createFromFormat('d-m-Y', $body->endDate)->setTime(0,0,0),
                new RequesterDefinition(
                    $body->requester->name,
                    $body->requester->email,
                    $body->requester->phoneNumber
                ),
                $body->comment ?? null
            )
        );

        $bookingRequest =  $bookingRequestRepository->find($body->id);
        return new JsonResponse(new RequestViewDefinition(
            $bookingRequest->id(),
            $bookingRequest->boatId(),
            $bookingRequest->portId(),
            $bookingRequest->numberOfPassengers()->value(),
            $bookingRequest->bookingDates()->startDate(),
            $bookingRequest->bookingDates()->endDate(),
            new RequesterDefinition(
                $bookingRequest->requester()->name(),
                $bookingRequest->requester()->email(),
                $bookingRequest->requester()->phoneNumber()
            ),
            $bookingRequest->comment(),
            $bookingRequest->isAvailable(),
            null != $bookingRequest->price()
                ? new PriceDefinition(
                    $bookingRequest->price()->amount(),
                    $bookingRequest->price()->currency()
                    )
                : null
        ), Response::HTTP_OK);

    }

}
