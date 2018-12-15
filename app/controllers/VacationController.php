<?php
 
use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;


class VacationController extends ControllerBase
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
     * Searches for vacation
     */
    public function searchAction()
    {
        $numberPage = 1;
        if ($this->request->isPost()) {
            $query = Criteria::fromInput($this->di, 'Vacation', $_POST);
            $this->persistent->parameters = $query->getParams();
        } else {
            $numberPage = $this->request->getQuery("page", "int");
        }

        $parameters = $this->persistent->parameters;
        if (!is_array($parameters)) {
            $parameters = [];
        }
        $parameters["order"] = "id";

        $vacation = Vacation::find($parameters);
        if (count($vacation) == 0) {
            $this->flash->notice("Поиск не дал результатов");

            $this->dispatcher->forward([
                "controller" => "vacation",
                "action" => "index"
            ]);

            return;
        }

        $paginator = new Paginator([
            'data' => $vacation,
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
     * Edits a vacation
     *
     * @param string $id
     */
    public function editAction($id)
    {
        if (!$this->request->isPost()) {

            $vacation = Vacation::findFirstByid($id);
            if (!$vacation) {
                $this->flash->error("Запись не найдена");

                $this->dispatcher->forward([
                    'controller' => "vacation",
                    'action' => 'index'
                ]);

                return;
            }

            $this->view->id = $vacation->id;

            $this->tag->setDefault("id", $vacation->id);
            $this->tag->setDefault("uid", $vacation->uid);
            $this->tag->setDefault("type", $vacation->type);
            $this->tag->setDefault("count_day", $vacation->count_day);
            $this->tag->setDefault("date_start", $vacation->date_start);
            $this->tag->setDefault("date_end", $vacation->date_end);
            $this->tag->setDefault("oid", $vacation->oid);
            $this->tag->setDefault("note", $vacation->note);
            
        }
    }

    /**
     * Creates a new vacation
     */
    public function createAction()
    {
        if (!$this->request->isPost()) {
            $this->dispatcher->forward([
                'controller' => "vacation",
                'action' => 'index'
            ]);

            return;
        }

        $vacation = new Vacation();
        $vacation->uid = $this->request->getPost("uid");
        $vacation->type = $this->request->getPost("type");
        $vacation->count_day = $this->request->getPost("count_day");
        $vacation->date_start = $this->request->getPost("date_start");
        $vacation->date_end = $this->request->getPost("date_end");
        $vacation->oid = $this->request->getPost("oid");
        $vacation->note = $this->request->getPost("note");
        

        if (!$vacation->save()) {
            foreach ($vacation->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "vacation",
                'action' => 'new'
            ]);

            return;
        }

        $this->flash->success("Запись успешно добавлена");

        $this->dispatcher->forward([
            'controller' => "vacation",
            'action' => 'index'
        ]);
    }

    /**
     * Saves a vacation edited
     *
     */
    public function saveAction()
    {

        if (!$this->request->isPost()) {
            $this->dispatcher->forward([
                'controller' => "vacation",
                'action' => 'index'
            ]);

            return;
        }

        $id = $this->request->getPost("id");
        $vacation = Vacation::findFirstByid($id);

        if (!$vacation) {
            $this->flash->error("vacation does not exist " . $id);

            $this->dispatcher->forward([
                'controller' => "vacation",
                'action' => 'index'
            ]);

            return;
        }

        $vacation->uid = $this->request->getPost("uid");
        $vacation->type = $this->request->getPost("type");
        $vacation->count_day = $this->request->getPost("count_day");
        $vacation->date_start = $this->request->getPost("date_start");
        $vacation->date_end = $this->request->getPost("date_end");
        $vacation->oid = $this->request->getPost("oid");
        $vacation->note = $this->request->getPost("note");
        

        if (!$vacation->save()) {

            foreach ($vacation->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "vacation",
                'action' => 'edit',
                'params' => [$vacation->id]
            ]);

            return;
        }

        $this->flash->success("Запись успешно изменена");

        $this->dispatcher->forward([
            'controller' => "vacation",
            'action' => 'index'
        ]);
    }

    /**
     * Deletes a vacation
     *
     * @param string $id
     */
    public function deleteAction($id)
    {
        $vacation = Vacation::findFirstByid($id);
        if (!$vacation) {
            $this->flash->error("Запись не найдена");

            $this->dispatcher->forward([
                'controller' => "vacation",
                'action' => 'index'
            ]);

            return;
        }

        if (!$vacation->delete()) {

            foreach ($vacation->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "vacation",
                'action' => 'search'
            ]);

            return;
        }

        $this->flash->success("Запись успешно удалена");

        $this->dispatcher->forward([
            'controller' => "vacation",
            'action' => "index"
        ]);
    }

}
