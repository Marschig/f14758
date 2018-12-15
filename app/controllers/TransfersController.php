<?php
 
use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;


class TransfersController extends ControllerBase
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
     * Searches for transfers
     */
    public function searchAction()
    {
        $numberPage = 1;
        if ($this->request->isPost()) {
            $query = Criteria::fromInput($this->di, 'Transfers', $_POST);
            $this->persistent->parameters = $query->getParams();
        } else {
            $numberPage = $this->request->getQuery("page", "int");
        }

        $parameters = $this->persistent->parameters;
        if (!is_array($parameters)) {
            $parameters = [];
        }
        $parameters["order"] = "id";

        $transfers = Transfers::find($parameters);
        if (count($transfers) == 0) {
            $this->flash->notice("Поиск не дал результатов");

            $this->dispatcher->forward([
                "controller" => "transfers",
                "action" => "index"
            ]);

            return;
        }

        $paginator = new Paginator([
            'data' => $transfers,
            'limit'=> 10000,
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
     * Edits a transfer
     *
     * @param string $id
     */
    public function editAction($id)
    {
        if (!$this->request->isPost()) {

            $transfer = Transfers::findFirstByid($id);
            if (!$transfer) {
                $this->flash->error("Запись не найдена");

                $this->dispatcher->forward([
                    'controller' => "transfers",
                    'action' => 'index'
                ]);

                return;
            }

            $this->view->id = $transfer->id;

            $this->tag->setDefault("id", $transfer->id);
            $this->tag->setDefault("uid", $transfer->uid);
            $this->tag->setDefault("date", $transfer->date);
            $this->tag->setDefault("aid", $transfer->aid);
            $this->tag->setDefault("pid", $transfer->pid);
            $this->tag->setDefault("cid", $transfer->cid);
            $this->tag->setDefault("salary", $transfer->salary);
            $this->tag->setDefault("oid", $transfer->oid);
            $this->tag->setDefault("cause", $transfer->cause);
            
        }
    }

    /**
     * Creates a new transfer
     */
    public function createAction()
    {
        if (!$this->request->isPost()) {
            $this->dispatcher->forward([
                'controller' => "transfers",
                'action' => 'index'
            ]);

            return;
        }

        $transfer = new Transfers();
        $transfer->uid = $this->request->getPost("uid");
        $transfer->date = $this->request->getPost("date");
        $transfer->aid = $this->request->getPost("aid");
        $transfer->pid = $this->request->getPost("pid");
        $transfer->cid = $this->request->getPost("cid");
        $transfer->salary = $this->request->getPost("salary");
        $transfer->oid = $this->request->getPost("oid");
        $transfer->cause = $this->request->getPost("cause");
        

        if (!$transfer->save()) {
            foreach ($transfer->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "transfers",
                'action' => 'new'
            ]);

            return;
        }

        $this->flash->success("Запись была успешно добавлена");

        $this->dispatcher->forward([
            'controller' => "transfers",
            'action' => 'index'
        ]);
    }

    /**
     * Saves a transfer edited
     *
     */
    public function saveAction()
    {

        if (!$this->request->isPost()) {
            $this->dispatcher->forward([
                'controller' => "transfers",
                'action' => 'index'
            ]);

            return;
        }

        $id = $this->request->getPost("id");
        $transfer = Transfers::findFirstByid($id);

        if (!$transfer) {
            $this->flash->error("transfer does not exist " . $id);

            $this->dispatcher->forward([
                'controller' => "transfers",
                'action' => 'index'
            ]);

            return;
        }

        $transfer->uid = $this->request->getPost("uid");
        $transfer->date = $this->request->getPost("date");
        $transfer->aid = $this->request->getPost("aid");
        $transfer->pid = $this->request->getPost("pid");
        $transfer->cid = $this->request->getPost("cid");
        $transfer->salary = $this->request->getPost("salary");
        $transfer->oid = $this->request->getPost("oid");
        $transfer->cause = $this->request->getPost("cause");
        

        if (!$transfer->save()) {

            foreach ($transfer->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "transfers",
                'action' => 'edit',
                'params' => [$transfer->id]
            ]);

            return;
        }

        $this->flash->success("Запись была успешно отредактирована");

        $this->dispatcher->forward([
            'controller' => "transfers",
            'action' => 'index'
        ]);
    }

    /**
     * Deletes a transfer
     *
     * @param string $id
     */
    public function deleteAction($id)
    {
        $transfer = Transfers::findFirstByid($id);
        if (!$transfer) {
            $this->flash->error("Запись не найдена");

            $this->dispatcher->forward([
                'controller' => "transfers",
                'action' => 'index'
            ]);

            return;
        }

        if (!$transfer->delete()) {

            foreach ($transfer->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "transfers",
                'action' => 'search'
            ]);

            return;
        }

        $this->flash->success("Запись успешно удалена");

        $this->dispatcher->forward([
            'controller' => "transfers",
            'action' => "index"
        ]);
    }

}
