<?php

namespace App\Controllers;

use App\Models\UserModel;
use Codeigniter\API\ResponseTrait;

class Signup extends BaseController
{
    use ResponseTrait;
    var $model, $validation;
    function __construct()
    {
        $this->model = new UserModel();
        $this->validation = \Config\Services::validation();
    }
    public function index()
    {
        return view('signup');
    }
    public function register()
    {
        $validation = \Config\Services::validation();
        $validation->setRules([
            'fname' => 'required',
            'lname' => 'required',
            'email' => 'required|valid_email|is_unique[users.email]',
            'password' => 'required|min_length[6]',
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            $errors = $validation->getErrors();
            $response = [
                'success' => false,
                'errors' => $errors
            ];
            return $this->response->setStatusCode(400)->setJSON($response);
        }

        $unique_id = substr(md5(microtime()), rand(0, 25), 6);
        $data = [
            'fname' => $this->request->getVar('fname'),
            'lname' => $this->request->getVar('lname'),
            'email' => $this->request->getVar('email'),
            'password' => password_hash($this->request->getVar('password'), PASSWORD_BCRYPT),
            'unique_id' => $unique_id,
            'status' => 'active'
        ];
        // $img = $this->request->getFile('img');
        // if ($img->isValid()) {
        //     $newName = $img->getRandomName();
        //     $img->move(ROOTPATH . 'public/' . getenv('dir.uploads.image'), $newName);
        //     $data['img'] = $newName;
        // }

        $this->model->insert($data);

        $response = [
            'success' => true,
            'message' => 'Registrasi berhasil!'
        ];
        return $this->response->setJSON($response);
    }
}
