<?php

defined('BASEPATH') or exit('No direct script access allowed');
// require APPPATH . 'libraries/RestController.php';
require_once("application/libraries/RestController.php");
require_once("application/libraries/Format.php");

use chriskacerguis\RestServer\RestController;

class ApiUserController extends RestController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('UserModel');
    }
    public function indexUser_get()
    {
        $users = new UserModel;
        $users = $users->get_user();
        $this->response($users, 200);
        // echo "hellllll";

        // print_r($users);
    }

    public function storeUser_post()
    {
        $users = new UserModel;

        // if (!$this->validate([
        //     'name'    => 'required',
        //     'email' => 'required|valid_email|is_unique[users.email]',
        //     'phone'  => 'required|numeric|max_length[10]'

        // ])) return $this->fail($this->validator->getErrors());

        $this->form_validation->set_rules("name", "Name", "required");
        $this->form_validation->set_rules("email", "Email", "required|valid_email|is_unique[users.email]");
        $this->form_validation->set_rules("phone", "Phone", "required|numeric");

        if ($this->form_validation->run() == FALSE) {
            $this->response([
                'status' => false,
                'message' => 'Validation Errors',
                'errors' =>  $this->validation_errors(),
            ], RestController::HTTP_BAD_REQUEST);
        } else {
            $data = [
                'name' =>  $this->input->post('name'),
                'email' => $this->input->post('email'),
                'phone' => $this->input->post('phone')
            ];
        }
        $result = $users->insert_user($data);
        if ($result > 0) {
            $this->response([
                'status' => true,
                'message' => 'NEW USER CREATED'
            ], RestController::HTTP_OK);

            // echo json_encode(array('status'=> TRUE,'message'=> 'NEW USER CREATED'));
        } else {
            $this->response([
                'status' => false,
                'message' => 'FAILED TO CREATE NEW USER'
            ], RestController::HTTP_BAD_REQUEST);
            // echo json_encode(array('status'=> false,'message'=> 'FAILED TO CREATE NEW USER','errors'=> $users->errors()));
        }
    }

    public function editUser_get($id)
    {
        $users = new UserModel;
        $users = $users->edit_user($id);
        // $this->response($users, 200);

        if ($users > 0) {
            $this->response([
                'status' => true,
                'message' => 'USER FOUND',
                'data' => $users
            ], RestController::HTTP_OK);

            // echo json_encode(array('status'=> TRUE,'message'=> 'NEW USER CREATED'));
        } else {
            $this->response([
                'status' => false,
                'message' => 'USER NOT FOUND'
            ], RestController::HTTP_BAD_REQUEST);
            // echo json_encode(array('status'=> false,'message'=> 'FAILED TO CREATE NEW USER','errors'=> $users->errors()));
        }
    }

    public function updateUser_post($id)
    {
        $users = new UserModel;
        $this->form_validation->set_rules("name", "Name", "required");
        $this->form_validation->set_rules("email", "Email", "required|valid_email|is_unique[users.email]");
        $this->form_validation->set_rules("phone", "Phone", "required|numeric");

        if ($this->form_validation->run() == FALSE) {
            $this->response([
                'status' => false,
                'message' => 'Validation Errors',
                'errors' =>  $this->validation_errors(),
            ], RestController::HTTP_BAD_REQUEST);
        } else {
            $data = [
                'name' =>  $this->input->post('name'),
                'email' => $this->input->post('email'),
                'phone' => $this->input->post('phone')
            ];
        }
        $result = $users->update_user($id, $data);
        if ($result > 0) {
            $this->response([
                'status' => true,
                'message' => 'USER UPDATED'
            ], RestController::HTTP_OK);
        } else {
            $this->response([
                'status' => false,
                'message' => 'FAILED TO UPDATE USER'
            ], RestController::HTTP_BAD_REQUEST);
        }
    }

    public function deleteUser_delete($id)
    {
        $users = new UserModel;
        $result = $users->delete_user($id);
        if ($result > 0) {
            $this->response([
                'status' => true,
                'message' => 'USER DELETED'
            ], RestController::HTTP_OK);
        } else {
            $this->response([
                'status' => false,
                'message' => 'FAILED TO DELETE USER'
            ], RestController::HTTP_BAD_REQUEST);
        }
    }
}
