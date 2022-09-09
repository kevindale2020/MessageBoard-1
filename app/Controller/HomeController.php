<?php


App::uses('AppController', 'Controller');

class HomeController extends AppController {

	public $uses = array('Users', 'UserInfo', 'Messages');

	public function index() {
		
	}

	public function profile() {

		if($this->request->isAjax()) {

			if($this->request->is('post')) {

				$this->layout = null;

				$this->autoRender = false;

				$data = $this->Auth->user();

				$id = $data[0]['Users']['id'];

				$user = $this->Users->find('all', array(
					'conditions' => array('Users.id' => $id)
				));

				if($user) {

					return json_encode(array('success' => 1, 'user' => $user[0]));
				}
				
			}
		}
	}

	public function editProfile() {

		if($this->request->isAjax()) {

			if($this->request->is('post')) {

				$this->layout = null;

				$this->autoRender = false;

				$data = $this->Auth->user();

				$id = $data[0]['Users']['id'];

				$query = $this->Users->read(null, $id);

				$profile = $this->request->data;

				// // image upload
				$filename = "";
				$name = $this->request->params['form']['image']['name'];
				$tmp_name = $this->request->params['form']['image']['tmp_name'];

				if(!empty($name)) {

			        $filename = $name;
			        move_uploaded_file($tmp_name, WWW_ROOT . 'img/' . $name);

				} else {

					$filename = $query['Users']['image'];
				}

				$this->Users->set(array(
					'image' => $filename,
					'name' => $profile['name'], 
					'email' => $profile['email'], 
					'gender' => $profile['gender'],
					'birthdate' => $profile['birthdate'],
					'hobby' => $profile['hobby'],
					'modified' => date("Y-m-d H:i:s")
				));  

				if($this->Users->save()) {

					return json_encode(array('success' => 1, 'message' => 'Successfully updated'));
				}

				// print_r($this->request->params['form']['image']['name']);        
			}
		}
	}

	public function newMessage() {

		if($this->request->isAjax()) {

			if($this->request->is('post')) {

				$this->layout = null;

				$this->autoRender = false;

				$data = $this->request->data;

				$data['user_id'] = $this->Auth->user()[0]['Users']['id'];

				if($this->Messages->save($data)) {

					return json_encode(array('success' => 1, 'message' => 'Your message has been sent'));
				}

			}
		}
	}

}