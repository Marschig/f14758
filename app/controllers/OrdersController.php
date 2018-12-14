<?php
 
use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;


class OrdersController extends ControllerBase
{
    /**
     * Index action
     */
    public function indexAction()
    {
        $this->persistent->parameters = null;
    }

    /**
     * Searches for orders
     */
    public function searchAction()
    {
        $numberPage = 1;
        if ($this->request->isPost()) {
            $query = Criteria::fromInput($this->di, 'Orders', $_POST);
            $this->persistent->parameters = $query->getParams();
        } else {
            $numberPage = $this->request->getQuery("page", "int");
        }

        $parameters = $this->persistent->parameters;
        if (!is_array($parameters)) {
            $parameters = [];
        }
        $parameters["order"] = "id";

        $orders = Orders::find($parameters);
        if (count($orders) == 0) {
            $this->flash->notice("Поиск не дал результатов");

            $this->dispatcher->forward([
                "controller" => "orders",
                "action" => "index"
            ]);

            return;
        }

        $paginator = new Paginator([
            'data' => $orders,
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
     * Edits a order
     *
     * @param string $id
     */
    public function editAction($id)
    {
        if (!$this->request->isPost()) {

            $order = Orders::findFirstByid($id);
            if (!$order) {
                $this->flash->error("Приказ не найден");

                $this->dispatcher->forward([
                    'controller' => "orders",
                    'action' => 'index'
                ]);

                return;
            }

            $this->view->id = $order->id;

            $this->tag->setDefault("id", $order->id);
            $this->tag->setDefault("date", $order->date);
            $this->tag->setDefault("number", $order->number);
            $this->tag->setDefault("note", $order->note);
            
        }
    }

    /**
     * Creates a new order
     */
    public function createAction()
    {
        if (!$this->request->isPost()) {
            $this->dispatcher->forward([
                'controller' => "orders",
                'action' => 'index'
            ]);

            return;
        }

        $order = new Orders();
        $order->date = $this->request->getPost("date");
        $order->number = $this->request->getPost("number");
        $order->note = $this->request->getPost("note");
        

        if (!$order->save()) {
            foreach ($order->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "orders",
                'action' => 'new'
            ]);

            return;
        }

        $this->flash->success("Приказ успешно добавлен");

        $this->dispatcher->forward([
            'controller' => "orders",
            'action' => 'index'
        ]);
    }

    /**
     * Saves a order edited
     *
     */
    public function saveAction()
    {

        if (!$this->request->isPost()) {
            $this->dispatcher->forward([
                'controller' => "orders",
                'action' => 'index'
            ]);

            return;
        }

        $id = $this->request->getPost("id");
        $order = Orders::findFirstByid($id);

        if (!$order) {
            $this->flash->error("order does not exist " . $id);

            $this->dispatcher->forward([
                'controller' => "orders",
                'action' => 'index'
            ]);

            return;
        }

        $order->date = $this->request->getPost("date");
        $order->number = $this->request->getPost("number");
        $order->note = $this->request->getPost("note");
        

        if (!$order->save()) {

            foreach ($order->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "orders",
                'action' => 'edit',
                'params' => [$order->id]
            ]);

            return;
        }

        $this->flash->success("Изменения успешно сохранены");

        $this->dispatcher->forward([
            'controller' => "orders",
            'action' => 'index'
        ]);
    }

    /**
     * Deletes a order
     *
     * @param string $id
     */
    public function deleteAction($id)
    {
        $order = Orders::findFirstByid($id);
        if (!$order) {
            $this->flash->error("order was not found");

            $this->dispatcher->forward([
                'controller' => "orders",
                'action' => 'index'
            ]);

            return;
        }

        if (!$order->delete()) {

            foreach ($order->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "orders",
                'action' => 'search'
            ]);

            return;
        }

        $this->flash->success("Приказ был удален");

        $this->dispatcher->forward([
            'controller' => "orders",
            'action' => "index"
        ]);
    }

}
