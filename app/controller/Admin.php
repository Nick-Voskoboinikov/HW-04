<?php


namespace App\controller;

use App\core\Controller;
use App\data\DB;
use App\models\User;




class Admin extends Controller{
    public function index() {
        $this->view->generate('admin.phtml','layout.phtml');
    }
    public function add() {
        $this->view->generate('user'.DIRECTORY_SEPARATOR.'add.phtml','layout.phtml');
    }
    public function login() {
        $this->view->generate('user'.DIRECTORY_SEPARATOR.'login.phtml','layout.phtml');
    }
    public function loginvk() {
        $this->view->generate('user'.DIRECTORY_SEPARATOR.'loginvk.phtml','layout.phtml');
    }
    public function logout() {
        $this->view->generate('user'.DIRECTORY_SEPARATOR.'logout.phtml','layout.phtml');
    }
    public function create() {
        
        if(!isset($_POST) || $_SERVER['REQUEST_METHOD'] !== 'POST'){
        header('Location: /admin/add');
        }

        $entity = new \stdClass();
        if(isset($_POST['username'])){
            if( count( DB::getUserByLogin($_POST['username']) ) > 0 ){
                $_SESSION['userExists']=true;
                header('Location: /admin/add');
                die();
            }
            
        $entity->username = $_POST['username'];
        $entity->password = $_POST['password'];
        if(isset($_POST['isAdmin']) && $_SESSION['role']==5){ // only admin can create admins
            $entity->role = 5;
        } else {
            $entity->role = 1;
        }
        $entity->email = isset($_POST['email'])?$_POST['email']:'';
        var_dump($entity);

        $user = new User($entity);
        $id = DB::create($user, 'user');
        
        if($id){
           header('Location: /admin/');

        }
        } // !isset($_POST['username'])
    }
    
}