<?php


App::uses('AppController', 'Controller');

class HomeController extends AppController {

	public $uses = array('Users', 'UserInfo', 'Messages', 'Comments');

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
				$data['posted'] = date("Y-m-d H:i:s");

				if($this->Messages->save($data)) {

					return json_encode(array('success' => 1, 'message' => 'Your message has been sent'));
				}

			}
		}
	}

	public function getRecipients() {

		if($this->request->isAjax()) {

			if($this->request->is('post')) {

				$this->layout = null;

				$this->autoRender = false;

				$id = $this->Auth->user()[0]['Users']['id'];

				$recipients = $this->Users->find('all', array(
					'fields' => array('Users.id', 'Users.image', 'Users.name'),
					'conditions' => array('NOT' => array('Users.id' => array($id)))
				));

				$option = "<select id='recipient' name='recipient' style='width: 50%'><option value='' selected hidden>Choose Recipient</option>
				";

				foreach($recipients as $recipient) {

					$image = ($recipient['Users']['image']!="") ? $recipient['Users']['image'] : 'user_none.png';

					$option .= '<option value='.$recipient['Users']['id'].' data-thumb='.$image.'>'.$recipient['Users']['name'].'</option>';
				}

				$option .= '</select>';

				return json_encode(array('success' => 1, 'recipients' => $option));
			}
		}
	}

	public function getMessageLists() {

		if($this->request->isAjax()) {

			if($this->request->is('post')) {

				$this->layout = null;

				$this->autoRender = false;

				$lists = $this->Messages->find('all', array(
					'limit' => 5,
					'order' => array('Messages.posted desc')
				));

				$query =  $this->Messages->find('all');

				$size = count($query);

				return json_encode(array('success' => 1, 'lists' => $lists, 'size' => $size));

			}
		}
	}

	public function searchMessage() {

		if($this->request->isAjax()) {

			if($this->request->is('post')) {

				$this->layout = null;

				$this->autoRender = false;

				$str = $this->request->data['searchStr'];

				$lists = $this->Messages->find('all', array(
					'conditions' => array('Messages.title LIKE' => "%$str%"),
					'order' => array('Messages.posted desc')
				));

				$size = count($lists);

				return json_encode(array('success' => 1, 'lists' => $lists, 'size' => $size));

			}
		}
	}

	public function getMessageLists2() {

		if($this->request->isAjax()) {

			if($this->request->is('post')) {

				$this->layout = null;

				$this->autoRender = false;

				$lists = $this->Messages->find('all', array(
					'limit' => $this->request->data['counter'],
					'order' => array('Messages.posted desc')
				));

				return json_encode(array('success' => 1, 'lists' => $lists));

			}
		}
	}

	public function details() {

		$messageID = $this->request->params['id'];

		$message = $this->Messages->find('first', array(
			'conditions' => array('Messages.id' => $messageID)
		));

		$this->set('message', $message);
	}

	public function comment() {

		if($this->request->isAjax()) {

			if($this->request->is('post')) {

				$this->layout = null;

				$this->autoRender = false;

				$data = $this->request->data;
				$data['user_id'] = $this->Auth->user()[0]['Users']['id'];
				$data['date'] = date("Y-m-d H:i:s");

				if($this->Comments->save($data)) {

					return json_encode(array('success' => 1, 'message' => 'Your comment has been added'));

				}

			}
		}
	}

	public function getComments() {

		if($this->request->isAjax()) {

			if($this->request->is('post')) {

				$this->layout = null;

				$this->autoRender = false;

				$id = $this->request->data['id'];

				$query = $this->Comments->find('all', array(
					'conditions' => array('Comments.message_id' => $id)		
				));

				$size = count($query);

				$comments = $this->Comments->find('all', array(
					'conditions' => array('Comments.message_id' => $id),
					'order' => array('Comments.date desc'),
					'limit' => 5		
				));

				if(count($comments) > 0) {
					$results = '<p><span class="badge">'.$size.'</span> Comments:</p><br>';

					foreach($comments as $comment) {

						$image = ($comment['Users']['image']!='') ? $comment['Users']['image'] : 'user_none.png';

						$results .= '<div class="row">';
						$results .= '<div class="col-sm-2 text-center">';
						$results .= '<img src='.$this->webroot.'/img/'.$image.' class="img-circle" height="65" width="65" alt="">';
						$results .= '</div>';
						$results .= '<div class="col-sm-10">';
						$results .= '<h4 style="font-size: 16px;">'.$comment['Users']['name'].' '.date("F j, Y g:i a",strtotime($comment['Comments']['date'])).'</h4>';
						$results .= '<p>'.$comment['Comments']['content'].'</p>';
						$results .= '<br>';
						$results .= '</div>';
						$results .= '</div>';
					}

					return json_encode(array('success' => 1, 'results' => $results, 'size' => $size));
				
				}
			}
		}
	}

	public function getComments2() {

		if($this->request->isAjax()) {

			if($this->request->is('post')) {

				$this->layout = null;

				$this->autoRender = false;

				$id = $this->request->data['id'];

				$query = $this->Comments->find('all', array(
					'conditions' => array('Comments.message_id' => $id)		
				));

				$size = count($query);

				$comments = $this->Comments->find('all', array(
					'conditions' => array('Comments.message_id' => $id),
					'order' => array('Comments.date desc'),
					'limit' => $this->request->data['counterComments']		
				));

				if(count($comments) > 0) {
					$results = '<p><span class="badge">'.$size.'</span> Comments:</p><br>';

					foreach($comments as $comment) {

						$image = ($comment['Users']['image']!='') ? $comment['Users']['image'] : 'user_none.png';

						$results .= '<div class="row">';
						$results .= '<div class="col-sm-2 text-center">';
						$results .= '<img src='.$this->webroot.'/img/'.$image.' class="img-circle" height="65" width="65" alt="">';
						$results .= '</div>';
						$results .= '<div class="col-sm-10">';
						$results .= '<h4 style="font-size: 16px;">'.$comment['Users']['name'].' <small>'.date("F j, Y g:i a",strtotime($comment['Comments']['date'])).'</small></h4>';
						$results .= '<p>'.$comment['Comments']['content'].'</p>';
						$results .= '<br>';
						$results .= '</div>';
						$results .= '</div>';
					}

					return json_encode(array('success' => 1, 'results' => $results, 'size' => $size));
				
				}
			}
		}
	}

	public function delete() {

		if($this->request->isAjax()) {

			if($this->request->is('post')) {

				$this->layout = null;

				$this->autoRender = false;

				$id = $this->request->data['id'];

				if($this->Messages->delete($id)) {

					return json_encode(array('success' => 1, 'message' => 'Successfully deleted'));
				}			
			}
		}
	}

}