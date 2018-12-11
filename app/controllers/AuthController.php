<?php

class AuthController extends ControllerBase
{

    public function indexAction()
    {

    }

    public function loginAction()
    {
        if (!$this->session->has("id_user")) {

            $id_user = $this->request->getPost('id_user', "int");
            $role = $this->request->getPost('role', "int");
            $password = $this->request->getPost('password', "string");


            if($user = Users::findFirstByTNumber($id_user) and $user->pass = md5($password) and $checkRole = UserRoles::findFirst("uid = $user->id and rid = $role")){

                $this->session->set("id_user", $user->id);
                $this->session->set("id_role", $role);
                $this->session->set("fio", $user->fio);

                $this->dispatcher->forward(
                    [
                        "controller" => "index",
                        "action" => "workroom",
                    ]
                );
            } else {
                $this->flash->error('Ошибка входа: Данные не соответстуют!');
                $this->dispatcher->forward(
                    [
                        "controller" => "index",
                        "action" => "index",
                    ]
                );
            }
        } else {
            $this->dispatcher->forward(
                [
                    "controller" => "index",
                    "action" => "workroom",
                ]
            );
        }
    }

    public function exitAction()
    {
        if (!$this->session->has("id_user")) {
            $this->response->redirect('/');
        } else {
            $this->session->destroy();
            $this->response->redirect('/');
        }
    }

}
