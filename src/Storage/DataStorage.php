<?php

namespace App\Storage;

use App\Model;

class DataStorage
{
    /**
     * @var \PDO
     */
    public $pdo;

    /**
     * TODO move connection params to env or config
     */
    public function __construct()
    {
        $this->pdo = new \PDO('mysql:dbname=task_tracker;host=127.0.0.1', 'user');
    }

    /**
     * TODO missing return type declaration
     * TODO change * in SQL-query to list of needed columns(unused created_at column)
     * @param int $projectId
     * @throws Model\NotFoundException
     */
    public function getProjectById($projectId)
    {
        $stmt = $this->pdo->query('SELECT * FROM project WHERE id = ' . (int) $projectId);

        if ($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            return new Model\Project($row);
        }

        throw new Model\NotFoundException();
    }

    /**
     * TODO missing $limit type
     * TODO missing $offset type
     * TODO missing return type declaration
     * TODO change * in SQL-query to list of needed columns(unused status and created_at columns)
     * TODO add `project_id` to prepared statement(execute comand)
     * @param int $project_id
     * @param int $limit
     * @param int $offset
     */
    public function getTasksByProjectId(int $project_id, $limit, $offset)
    {
        $stmt = $this->pdo->query("SELECT * FROM task WHERE project_id = $project_id LIMIT ?, ?");
        $stmt->execute([$limit, $offset]);

        $tasks = [];
        foreach ($stmt->fetchAll() as $row) {
            $tasks[] = new Model\Task($row);
        }

        return $tasks;
    }

    /**
     * TODO missing $projectId type
     * TODO missing return type declaration
     * TODO SQL-injection can be used in sql query
     * TODO determine $data['id'] by LAST_INSERT_ID()
     * @param array $data
     * @param int $projectId
     * @return Model\Task
     */
    public function createTask(array $data, $projectId)
    {
        $data['project_id'] = $projectId;

        $fields = implode(',', array_keys($data));
        $values = implode(',', array_map(function ($v) {
            return is_string($v) ? '"' . $v . '"' : $v;
        }, $data));

        $this->pdo->query("INSERT INTO task ($fields) VALUES ($values)");
        $data['id'] = $this->pdo->query('SELECT MAX(id) FROM task')->fetchColumn();

        return new Model\Task($data);
    }
}
