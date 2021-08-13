<?php

declare(strict_types=1);

namespace Presentation\Http\Actions\PClass;

use Domain\CommandBus\CommandBusInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Presentation\Http\Actions\BaseAction;
use Presentation\Http\Adapters\PClass\DeletePClassAdapter;

class DeletePClassAction extends BaseAction
{
    public const ROUTE_NAME = 'PClass.delete';

    private DeletePClassAdapter $adapter;
    private CommandBusInterface $commandBus;

    public function __construct(
        DeletePClassAdapter $adapter,
        CommandBusInterface $commandBus
    ) {
        $this->adapter = $adapter;
        $this->commandBus = $commandBus;
    }

    public function execute(Request $request): JsonResponse
    {
        $command = $this->adapter->adapt($request);
        $this->commandBus->handle($command);

        return $this->respondWithSuccess(
            []
        );
    }
}
