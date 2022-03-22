<?php

// TODO fix namespace Api -> App
namespace Api\Controller;

use App\Model;
use App\Storage\DataStorage;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ProjectController
{
    /**
     * @var DataStorage
     */
    private $storage;

    public function __construct(DataStorage $storage)
    {
        $this->storage = $storage;
    }

    /**
     * @param Request $request
     *
     * @Route("/project/{id}", name="project", method="GET")
     */
    public function projectAction(Request $request)
    {
        try {
            //TODO force type conversion (int)$request->get('id')
            $project = $this->storage->getProjectById($request->get('id'));

            // TODO change Response to JsonResponse and send raw data
            return new Response($project->toJson());
        } catch (Model\NotFoundException $e) {
            // TODO change Response to JsonResponse and make array with key "error" and value "Not found"
            return new Response('Not found', 404);
        } catch (\Throwable $e) {
            // TODO change Response to JsonResponse and make array with key "error" and value "Something went wrong"
            // TODO add to readme with 500 error
            return new Response('Something went wrong', 500);
        }
    }

    /**
     * TODO change limit and offset variables type to number in readme
     * TODO add 404 if project was not exist and mark in readme
     * TODO add 500 if some error was occurred and mark in readme
     *
     * @param Request $request
     *
     * @Route("/project/{id}/tasks", name="project-tasks", method="GET")
     */
    public function projectTaskPagerAction(Request $request)
    {
        //TODO force type conversion $request->get params to int
        $tasks = $this->storage->getTasksByProjectId(
            $request->get('id'),
            $request->get('limit'),
            $request->get('offset')
        );

        // TODO change Response to JsonResponse and send raw data
        return new Response(json_encode($tasks));
    }

    /**
     * @param Request $request
     *
     * TODO change method to POST from readme or change here to post(and change in front app)
     * TODO move create task from JsonResponse and wrap with try\catch/
     * TODO add 201 http code if task was successfully added
     * TODO add 500 if some error was occurred(task not created with exception) and mark in readme
     * @Route("/project/{id}/tasks", name="project-create-task", method="PUT")
     */
    public function projectCreateTaskAction(Request $request)
    {
		$project = $this->storage->getProjectById($request->get('id'));
		if (!$project) {
            // TODO add http code
			return new JsonResponse(['error' => 'Not found']);
		}

		return new JsonResponse(
			$this->storage->createTask($_REQUEST, $project->getId())
		);
    }
}
