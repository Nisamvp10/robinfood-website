<?php
namespace App\Controllers;
use App\Models\UsersregistrationsModel;
class AuthController extends BaseController
{
    public function register()
    {
        if(!$this->request->isAJAX()){
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Invalid request',
            ]);
        }
        $rules = [
            'name' => 'required|min_length[2]',
            'email' => 'required|valid_email|is_unique[usersregistrations.email]',
            'phone' => 'required|numeric|exact_length[10]|is_unique[usersregistrations.phone]',
            'password' => 'required|min_length[6]|max_length[50]',
        ];
        if(!$this->validate($rules)){
            return $this->response->setJSON([
                'success' => false,
                'errors' => $this->validator->getErrors(),
            ]);
        }

        $data = [
            'name' => $this->request->getPost('name'),
            'email' => $this->request->getPost('email'),
            'phone' => $this->request->getPost('phone'),
            'password' => password_hash($this->request->getPost('password'),PASSWORD_DEFAULT)
        ];
        $userModel = new UsersregistrationsModel();
        if($userModel->insert($data)){
            session()->set('user', [
                'isLoggedIn' => true,
                'userId' => $userModel->insertID(),
                'name' => $data['name'],
                'email' => $data['email'],
                'phone' => $data['phone'],
            ]);
            //check ani items in his cart 

            return $this->response->setJSON([
                'success' => true,
                'message' => 'User registered successfully',
                'url' => base_url('checkout')
            ]);
        }
        return $this->response->setJSON([
            'success' => false,
            'message' => 'User registration failed',
        ]);
    }
    public function login()
    {
        if(!$this->request->isAJAX()){
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Invalid request',
            ]);
        }
        $rules = [
            'username' => 'required',
            'pwd' => 'required|min_length[6]|max_length[50]',
        ];
        if(!$this->validate($rules)){
            return $this->response->setJSON([
                'success' => false,
                'errors' => $this->validator->getErrors(),
            ]);
        }
        $userModel = new UsersregistrationsModel();
        $user = $userModel->where('email', $this->request->getPost('username'))->orWhere('phone', $this->request->getPost('username'))->first();
        if($user){
            if(password_verify($this->request->getPost('pwd'), $user['password'])){
                if($user['status'] ==0) {
                    return $this->response->setJSON([
                        'success' => false,
                        'errors' => ['pwd' => 'Your Account is Blocked Please contact to Our team'],
                    ]);
                }
                session()->set('user', [
                    'isLoggedIn' => true,
                    'userId' => $user['id'],
                    'name' => $user['name'],
                    'email' => $user['email'],
                    'phone' => $user['phone'],
                ]);
                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'User logged in successfully',
                    'url' => base_url('checkout')
                ]);
            }else{
                return $this->response->setJSON([
                    'success' => false,
                    'errors' => ['pwd' => 'Invalid password'],
                ]);
            }
        }else{
            return $this->response->setJSON([
                'success' => false,
                'errors' => ['username' => 'Invalid username'],
            ]);
        }
        return $this->response->setJSON([
            'success' => false,
            'message' => 'Invalid username or password',
        ]);
    }
}