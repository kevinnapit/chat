<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\Controller;

class AuthController extends Controller
{
    public function index()
    {
        $userModel = new UserModel();
        $data['users'] = $userModel->findAll();
        return view('chat/index', $data);
    }
    public function register()
    {
        return view('auth/register');
    }

    public function storeRegister()
    {
        $validation = \Config\Services::validation();

        $validation->setRules([
            'username' => 'required|min_length[3]|max_length[255]',
            'password' => 'required|min_length[3]|max_length[255]',
            'profile_image' => 'uploaded[profile_image]|is_image[profile_image]|mime_in[profile_image,image/jpg,image/jpeg,image/png]'
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $profilePicture = $this->request->getFile('profile_image');
        $profilePictureName = $profilePicture->getRandomName();
        $profilePicture->move(WRITEPATH . '../public/uploads/image', $profilePictureName);

        $userModel = new UserModel();
        $userModel->save([
            'username' => $this->request->getPost('username'),
            'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'profile_image' => $profilePictureName
        ]);

        return redirect()->to('/login');
    }

    // public function storeRegister()
    // {
    //     $userModel = new UserModel();

    //     $data = [
    //         'username' => $this->request->getPost('username'),
    //         'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
    //         'role' => 'user'
    //     ];

    //     $userModel->save($data);
    //     return redirect()->to('/login');
    // }

    public function login()
    {
        // $userModel = new UserModel();
        // $userModel->update(session()->get('user_id'), ['is_online' => true]);
        return view('auth/login');
    }

    public function doLogin()
    {
        $session = session();
        $userModel = new UserModel();
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        $user = $userModel->where('username', $username)->first();

        if ($user && password_verify($password, $user['password'])) {
            $session->set([
                'user_id' => $user['id'],
                'username' => $user['username'],
                'role' => $user['role'],
                'isLoggedIn' => true,
            ]);
            return redirect()->to('/index');
        } else {
            $session->setFlashdata('error', 'Username atau Password salah');
            return redirect()->to('/login');
        }
    }

    public function logout()
    {
        $session = session();
        $session->destroy();
        // $userModel = new UserModel();
        // $userModel->update(session()->get('user_id'), ['is_online' => false]);
        return redirect()->to('/login');
    }
}
