<?php
namespace Ijdb;

class IjdbRoutes implements \Ninja\Routes   //enforced class by the \Ninja\Routes interface.
{
    public function getRoutes()
    {
        $page = NULL;

        include __DIR__ . '/../../includes/DatabaseConnection.php';

        $jokesTable = new \Ninja\DatabaseTable($pdo, 'joke', 'id');
        $authorsTable = new \Ninja\DatabaseTable($pdo, 'author', 'id');

        $jokeController = new \Ijdb\Controllers\Joke($jokesTable, $authorsTable);

        // construct whole route respond to request.
        $routes = [
            'joke/list' => [
                'GET' => [
                    'controller' => $jokeController, 
                    'action' => 'list'
                ]
            ],
            'joke/edit' => [
                'POST' => [
                    'controller' => $jokeController, 
                    'action' => 'saveEdit'
                ],
                'GET' => [
                    'controller' => $jokeController, 
                    'action' => 'edit'
                ]
            ],
            'joke/delete' => [
                'POST' => [
                    'controller' => $jokeController, 
                    'action' => 'delete'
                ]
            ],
            '' => [
                'GET' => [
                    'controller' => $jokeController, 
                    'action' => 'home'
                ]
            ],
        ];

        return $routes;

        /*
        if ($route === 'joke/list') {
            $controller = new \Ijdb\Controllers\Joke($jokesTable, $authorsTable);
            $page = $controller->list();
        }
        else if ($route === '') {
            $controller = new \Ijdb\Controllers\Joke($jokesTable, $authorsTable);
            $page = $controller->home();
        }
        else if ($route === 'joke/edit') {
            $controller = new \Ijdb\Controllers\Joke($jokesTable, $authorsTable);
            $page = $controller->edit();
        }
        else if ($route === 'joke/delete') {
            $controller = new \Ijdb\Controllers\Joke($jokesTable, $authorsTable);
            $page = $controller->delete();
        }
        else if ($route === 'register') {
            $controller = new \Ijdb\Controllers\Register($authorsTable);
            $page = $controller->showForm();
        }

        return $page;
        */
    }
}