<?php
 
use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;


class HolidaysController extends ControllerBase
{
    public function initialize()
    {

        if(!$this->session->has("id_user") or $this->session->get("id_role") != 1){
            $this->dispatcher->forward(
                [
                    "controller" => "index",
                    "action" => "index",
                ]
            );
        }

    }

    /**
     * Index action
     */
    public function indexAction()
    {
        $this->persistent->parameters = null;
    }

    /**
     * Searches for holidays
     */
    public function searchAction()
    {
        $numberPage = 1;
        if ($this->request->isPost()) {
            $query = Criteria::fromInput($this->di, 'Holidays', $_POST);
            $this->persistent->parameters = $query->getParams();
        } else {
            $numberPage = $this->request->getQuery("page", "int");
        }

        $parameters = $this->persistent->parameters;
        if (!is_array($parameters)) {
            $parameters = [];
        }
        $parameters["order"] = "id";

        $holidays = Holidays::find($parameters);
        if (count($holidays) == 0) {
            $this->flash->notice("Поиск не дал результатов");

            $this->dispatcher->forward([
                "controller" => "holidays",
                "action" => "index"
            ]);

            return;
        }

        $paginator = new Paginator([
            'data' => $holidays,
            'limit'=> 100000,
            'page' => $numberPage
        ]);

        $this->view->page = $paginator->getPaginate();
    }

    /**
     * Displays the creation form
     */
    public function newAction()
    {

    }

    /**
     * Edits a holiday
     *
     * @param string $id
     */
    public function editAction($id)
    {
        if (!$this->request->isPost()) {

            $holiday = Holidays::findFirstByid($id);
            if (!$holiday) {
                $this->flash->error("Запись не найдена");

                $this->dispatcher->forward([
                    'controller' => "holidays",
                    'action' => 'index'
                ]);

                return;
            }

            $this->view->id = $holiday->id;

            $this->tag->setDefault("id", $holiday->id);
            $this->tag->setDefault("date", $holiday->date);
            $this->tag->setDefault("name", $holiday->name);
            
        }
    }

    /**
     * Creates a new holiday
     */
    public function createAction()
    {
        if (!$this->request->isPost()) {
            $this->dispatcher->forward([
                'controller' => "holidays",
                'action' => 'index'
            ]);

            return;
        }

        $holiday = new Holidays();
        $holiday->date = $this->request->getPost("date");
        $holiday->name = $this->request->getPost("name");
        

        if (!$holiday->save()) {
            foreach ($holiday->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "holidays",
                'action' => 'new'
            ]);

            return;
        }

        $this->flash->success("Запись успешно добавлена");

        $this->dispatcher->forward([
            'controller' => "holidays",
            'action' => 'index'
        ]);
    }

    /**
     * Saves a holiday edited
     *
     */
    public function saveAction()
    {

        if (!$this->request->isPost()) {
            $this->dispatcher->forward([
                'controller' => "holidays",
                'action' => 'index'
            ]);

            return;
        }

        $id = $this->request->getPost("id");
        $holiday = Holidays::findFirstByid($id);

        if (!$holiday) {
            $this->flash->error("holiday does not exist " . $id);

            $this->dispatcher->forward([
                'controller' => "holidays",
                'action' => 'index'
            ]);

            return;
        }

        $holiday->date = $this->request->getPost("date");
        $holiday->name = $this->request->getPost("name");
        

        if (!$holiday->save()) {

            foreach ($holiday->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "holidays",
                'action' => 'edit',
                'params' => [$holiday->id]
            ]);

            return;
        }

        $this->flash->success("Запись успешно изменена");

        $this->dispatcher->forward([
            'controller' => "holidays",
            'action' => 'index'
        ]);
    }

    /**
     * Deletes a holiday
     *
     * @param string $id
     */
    public function deleteAction($id)
    {
        $holiday = Holidays::findFirstByid($id);
        if (!$holiday) {
            $this->flash->error("Запись не найдена");

            $this->dispatcher->forward([
                'controller' => "holidays",
                'action' => 'index'
            ]);

            return;
        }

        if (!$holiday->delete()) {

            foreach ($holiday->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "holidays",
                'action' => 'search'
            ]);

            return;
        }

        $this->flash->success("Запись успешно удалена");

        $this->dispatcher->forward([
            'controller' => "holidays",
            'action' => "index"
        ]);
    }

}
