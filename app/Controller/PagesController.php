<?php
/**
 * Static content controller.
 *
 * This file will render views from views/pages/
 *
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */

App::uses('AppController', 'Controller');

/**
 * Static content controller
 *
 * Override this controller by placing a copy in controllers directory of an application
 *
 * @package       app.Controller
 * @link https://book.cakephp.org/2.0/en/controllers/pages-controller.html
 */
class PagesController extends AppController {

/**
 * This controller does not use a model
 *
 * @var array
 */
	public $uses = array('Users');

/**
 * Displays a view
 *
 * @return CakeResponse|null
 * @throws ForbiddenException When a directory traversal attempt.
 * @throws NotFoundException When the view file could not be found
 *   or MissingViewException in debug mode.
 */

	public function beforeFilter() {

        parent::beforeFilter();

        $this->Auth->allow();
    }

	public function display() {
		$path = func_get_args();

		$count = count($path);
		if (!$count) {
			return $this->redirect('/');
		}
		if (in_array('..', $path, true) || in_array('.', $path, true)) {
			throw new ForbiddenException();
		}
		$page = $subpage = $title_for_layout = null;

		if (!empty($path[0])) {
			$page = $path[0];
		}
		if (!empty($path[1])) {
			$subpage = $path[1];
		}
		if (!empty($path[$count - 1])) {
			$title_for_layout = Inflector::humanize($path[$count - 1]);
		}
		$this->set(compact('page', 'subpage', 'title_for_layout'));

		try {
			$this->render(implode('/', $path));
		} catch (MissingViewException $e) {
			if (Configure::read('debug')) {
				throw $e;
			}
			throw new NotFoundException();
		}

		if($this->Auth->login($this->Auth->user())) { 

			return $this->redirect($this->Auth->redirectUrl());
		}
	}

	public function register() {

		if($this->request->isAjax()) {

			$this->layout = null;

			$this->autoRender = false;

			if($this->request->is('post')) {

				$data = $this->request->data;

				$data['role_id'] = 2;
				$data['password'] = AuthComponent::password($this->request->data['password']);

				$query = $this->Users->find('count', array(
					'conditions' => array('Users.email' => $data['email'])
				));

				if($query) {

					return json_encode(array('success' => 0, 'messageErr' => 'Email already exists'));
				}

				if($this->Users->save($data)) {

					return json_encode(array('success' => 1, 'message' => 'You are now registered'));	
				}
			}
		}

	}

	public function login() {

		if($this->request->isAjax()) {

			$this->layout = null;

			$this->autoRender = false;

			if($this->request->is('post')) {

				$password = AuthComponent::password($this->request->data['password']);

				$user = $this->Users->find('all', array(

					'conditions' => array(
						'Users.email' => $this->request->data['email'], 'Users.password' => $password
					)
				));
	
				if($this->Auth->login($user)) { 

					return json_encode(array('success' => 1, 'message' => 'Logged in', 'data' => $this->Auth->user()));
				} else {

					return json_encode(array('success' => 0, 'message' => 'Invalid credentials'));
				}
			}
		}
	}

	public function logout() {

		$this->redirect($this->Auth->logout());
	}

	public function thankyou() {

	}
}
