<?php
 
use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;


class UsersController extends ControllerBase
{
    /**
     * Index action
     */
    public function indexAction()
    {
        $this->persistent->parameters = null;
    }

    /**
     * Searches for users
     */
    public function searchAction()
    {
        $numberPage = 1;
        if ($this->request->isPost()) {
            $query = Criteria::fromInput($this->di, 'Users', $_POST);
            $this->persistent->parameters = $query->getParams();
        } else {
            $numberPage = $this->request->getQuery("page", "int");
        }

        $parameters = $this->persistent->parameters;
        if (!is_array($parameters)) {
            $parameters = [];
        }
        $parameters["order"] = "id";

        $users = Users::find($parameters);
        if (count($users) == 0) {
            $this->flash->notice("The search did not find any users");

            $this->dispatcher->forward([
                "controller" => "users",
                "action" => "index"
            ]);

            return;
        }

        $paginator = new Paginator([
            'data' => $users,
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
     * Edits a user
     *
     * @param string $id
     */
    public function editAction($id)
    {
        if (!$this->request->isPost()) {

            $user = Users::findFirstByid($id);
            if (!$user) {
                $this->flash->error("user was not found");

                $this->dispatcher->forward([
                    'controller' => "users",
                    'action' => 'index'
                ]);

                return;
            }

            $this->view->id = $user->id;
            $this->view->status = $user->status;

            $this->tag->setDefault("id", $user->id);
            $this->tag->setDefault("t_number", $user->t_number);
            $this->tag->setDefault("fio", $user->fio);
            $this->tag->setDefault("pass", $user->pass);
            $this->tag->setDefault("reg_number", $user->reg_number);
            $this->tag->setDefault("identity_code", $user->identity_code);
            $this->tag->setDefault("gender", $user->gender);
            $this->tag->setDefault("birth_date", $user->birth_date);
            $this->tag->setDefault("date_rec", $user->date_rec);
            $this->tag->setDefault("oid_rec", $user->oid_rec);
            $this->tag->setDefault("pid", $user->pid);
            $this->tag->setDefault("aid", $user->aid);
            $this->tag->setDefault("cid", $user->cid);
            $this->tag->setDefault("date_dis", $user->date_dis);
            $this->tag->setDefault("cause_dis", $user->cause_dis);
            $this->tag->setDefault("oid_dis", $user->oid_dis);
            $this->tag->setDefault("status", $user->status);
            
        }
    }

    /**
     * Creates a new user
     */
    public function createAction()
    {
        if (!$this->request->isPost()) {
            $this->dispatcher->forward([
                'controller' => "users",
                'action' => 'index'
            ]);

            return;
        }

        $user = new Users();
        $user->t_number = $this->request->getPost("t_number");
        $user->fio = $this->request->getPost("fio");
        $user->pass = md5($this->request->getPost("pass"));
        $user->reg_number = $this->request->getPost("reg_number");
        $user->identity_code = $this->request->getPost("identity_code");
        $user->gender = $this->request->getPost("gender");
        $user->birth_date = $this->request->getPost("birth_date");
        $user->date_rec = $this->request->getPost("date_rec");
        $user->oid_rec = $this->request->getPost("oid_rec");
        $user->pid = $this->request->getPost("pid");
        $user->aid = $this->request->getPost("aid");
        $user->cid = $this->request->getPost("cid");
        $user->status = 1;
        

        if (!$user->save()) {
            foreach ($user->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "users",
                'action' => 'new'
            ]);

            return;
        }

        $this->flash->success("Карточка создана");

        $this->dispatcher->forward([
            'controller' => "index",
            'action' => 'workroom'
        ]);
    }

    /**
     * Saves a user edited
     *
     */
    public function saveAction()
    {

        if (!$this->request->isPost()) {
            $this->dispatcher->forward([
                'controller' => "users",
                'action' => 'index'
            ]);

            return;
        }

        $id = $this->request->getPost("id");
        $user = Users::findFirstByid($id);

        if (!$user) {
            $this->flash->error("user does not exist " . $id);

            $this->dispatcher->forward([
                'controller' => "users",
                'action' => 'index'
            ]);

            return;
        }

//        $user->t_number = $this->request->getPost("t_number");
        $user->fio = $this->request->getPost("fio");
        if($this->request->getPost("new_pass")) $user->pass = md5($this->request->getPost("new_pass"));
        $user->reg_number = $this->request->getPost("reg_number");
        $user->identity_code = $this->request->getPost("identity_code");
        $user->gender = $this->request->getPost("gender");
        $user->birth_date = $this->request->getPost("birth_date");
        $user->date_rec = $this->request->getPost("date_rec");
        $user->oid_rec = $this->request->getPost("oid_rec");
        $user->pid = $this->request->getPost("pid");
        $user->aid = $this->request->getPost("aid");
        $user->cid = $this->request->getPost("cid");



        if($this->request->getPost("date_dis") and $this->request->getPost("cause_dis") and $this->request->getPost("oid_dis"))
        {
            $user->date_dis = $this->request->getPost("date_dis");
            $user->cause_dis = $this->request->getPost("cause_dis");
            $user->oid_dis = $this->request->getPost("oid_dis");

            $user->status = 2;
        }

//        $user->status = $this->request->getPost("status");
        

        if (!$user->save()) {

            foreach ($user->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->response->redirect("users/edit/".$user->id);

            $this->dispatcher->forward([
                'controller' => "users",
                'action' => 'edit',
                'params' => [$user->id]
            ]);

            return;
        }

        $this->flash->success("Данные успешно изменены");

        $this->dispatcher->forward([
            'controller' => "index",
            'action' => 'workroom'
        ]);
    }

    /**
     * Deletes a user
     *
     * @param string $id
     */
    public function deleteAction($id)
    {
        $user = Users::findFirstByid($id);
        if (!$user) {
            $this->flash->error("user was not found");

            $this->dispatcher->forward([
                'controller' => "users",
                'action' => 'index'
            ]);

            return;
        }

        if (!$user->delete()) {

            foreach ($user->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "index",
                'action' => 'workroom'
            ]);

            return;
        }

        $this->flash->success("Карточка была удалена");

        $this->dispatcher->forward([
            'controller' => "index",
            'action' => 'workroom'
        ]);
    }

    public function restoreAction($id)
    {
        $user = Users::findFirstByid($id);
        if (!$user) {
            $this->flash->error("user was not found");

            $this->dispatcher->forward([
                'controller' => "index",
                'action' => 'workroom'
            ]);

            return;
        }

        if ($user->status != 2) {

            $this->dispatcher->forward([
                'controller' => "index",
                'action' => 'workroom'
            ]);

            return;
        }
        $user->date_dis = null;
        $user->cause_dis = null;
        $user->oid_dis = null;
        $user->status = 1;
        $user->save();

        $this->flash->success("Статус был успешно изменен");

        $this->dispatcher->forward([
            'controller' => "index",
            'action' => "workroom"
        ]);
    }

}
