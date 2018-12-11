<?php

class IndexController extends ControllerBase
{

    public function indexAction()
    {
        if($this->session->has("id_user")){
            $this->dispatcher->forward(
                [
                    "controller" => "index",
                    "action" => "workroom",
                ]
            );
        }
    }

    public function workroomAction()
    {
        if(!$this->session->has("id_user")){
            $this->dispatcher->forward(
                [
                    "controller" => "index",
                    "action" => "index",
                ]
            );
        }

        $this->view->user_fio = $this->session->get("fio");

        if($this->session->get("id_role") == 1){

            $this->view->user_role_1 = 1;
            $this->view->all_users = Users::find();
        }

    }

}

