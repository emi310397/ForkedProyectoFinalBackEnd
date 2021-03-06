<?php

declare(strict_types=1);

namespace Presentation\Http\Adapters\Task;

use Application\Commands\Task\CreateTaskCommand;
use Domain\Adapters\CommandAdapter;
use Domain\Interfaces\Repositories\PClassRepositoryInterface;
use Illuminate\Http\Request;
use Presentation\Interfaces\ValidatorServiceInterface;

class CreateTaskAdapter extends CommandAdapter
{
    private PClassRepositoryInterface $PClassRepository;

    private const PCLASS_ID_PARAM = 'id';
    private const TITLE_PARAM = 'title';
    private const DESCRIPTION_PARAM = 'description';
    private const FROM_DATE_PARAM = 'fromDate';
    private const TO_DATE_PARAM = 'toDate';

    public function __construct(
        ValidatorServiceInterface $validator,
        PClassRepositoryInterface $PClassRepository
    ) {
        parent::__construct($validator);
        $this->PClassRepository = $PClassRepository;
    }

    public function getRules(): array
    {
        return [
            self::PCLASS_ID_PARAM => 'bail|required|integer|gt:0',
            self::TITLE_PARAM => 'bail|required|string',
            self::DESCRIPTION_PARAM => 'bail|required|string',
            self::FROM_DATE_PARAM => 'bail|required|date',
            self::TO_DATE_PARAM => 'bail|required|date|after:' . self::FROM_DATE_PARAM,
        ];
    }

    public function getMessages(): array
    {
        return [
            self::PCLASS_ID_PARAM . 'required' => __('The id of the class is required'),
            self::PCLASS_ID_PARAM . 'integer' => __('The id of the class must be a number'),
            self::PCLASS_ID_PARAM . 'gt' => __('The id of the class must be a greater than 0'),
            self::TITLE_PARAM . 'required' => __('The title of the task is required'),
            self::TITLE_PARAM . 'string' => __('The title of the task must be a string'),
            self::DESCRIPTION_PARAM . 'required' => __('The description of the task is required'),
            self::DESCRIPTION_PARAM . 'string' => __('The description of the task must be a string'),
            self::FROM_DATE_PARAM . 'required' => __('The start date of the task is required'),
            self::FROM_DATE_PARAM . 'date' => __('The start date of the task must be a valid date'),
            self::TO_DATE_PARAM . 'required' => __('The end date of the task is required'),
            self::TO_DATE_PARAM . 'date' => __('The end date of the task must be a valid date'),
            self::TO_DATE_PARAM . 'after' => __('The end date of the task must be higher than the start date'),
        ];
    }

    public function adapt(Request $request): CreateTaskCommand
    {
        $this->assertRulesAreValid($request->all());

        $PClass = $this->PClassRepository->getByIdOrFail($request->get(self::PCLASS_ID_PARAM));

        return new CreateTaskCommand(
            $PClass,
            $request->get(self::TITLE_PARAM),
            $request->get(self::DESCRIPTION_PARAM),
            $request->get(self::FROM_DATE_PARAM),
            $request->get(self::TO_DATE_PARAM)
        );
    }
}
