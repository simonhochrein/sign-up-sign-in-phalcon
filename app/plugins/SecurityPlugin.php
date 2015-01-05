<?php

use Phalcon\Acl;
use Phalcon\Acl\Role;
use Phalcon\Acl\Resource;
use Phalcon\Events\Event;
use Phalcon\Mvc\User\Plugin;
use Phalcon\Mvc\Dispatcher;
use Phalcon\Acl\Adapter\Memory as AclList;

/**
 * SecurityPlugin
 *
 * This is the security plugin which controls that users only have access to the modules they're assigned to
 */
class SecurityPlugin extends Plugin
{

	/**
	 * Returns an existing or new access control list
	 *
	 * @returns AclList
	 */
	public function getAcl()
	{

//		throw new \Exception("something");

		if (!isset($this->persistent->acl)) {

			$acl = new AclList();

			$acl->setDefaultAction(Acl::DENY);

			//Register roles
			$roles = array(
				'users'  => new Role('Users'),
				'guests' => new Role('Guests'),
                'admin'  => new Role('Admin')

			);

			foreach ($roles as $role) {
				$acl->addRole($role);

			}


			//Private area resources
			$privateResources = array(

				'secret'	=>	array('index')


			);

			foreach ($privateResources as $resource => $actions) {
				$acl->addResource(new Resource($resource), $actions);
			}
            $adminResources = array(
				'secret' => array('index')

			);

			foreach ($adminResources as $resource => $actions) {
				$acl->addResource(new Resource($resource), $actions);
			}



			//Public area resources
			$publicResources = array(
				'index'      => array('index'),
				'session'    => array('index', 'register', 'start', 'end'),
				'register'   => array('index'),
				'errors'	=> array('show404','show401','show500')
			);

			foreach ($publicResources as $resource => $actions) {
				$acl->addResource(new Resource($resource), $actions);
			}

			//Grant access to public areas to both users and guests
			foreach ($roles as $role) {
				foreach ($publicResources as $resource => $actions) {
					$acl->allow($role->getName(), $resource, '*');
				}
			}

			//Grant acess to private area to role Users
			foreach ($privateResources as $resource => $actions) {
				foreach ($actions as $action){
					$acl->allow('Users', $resource, $action);
				}
			}
            foreach ($adminResources as $resource => $actions) {
				foreach ($actions as $action){
					$acl->allow('Admin', $resource, $action);
				}
			}


			//The acl is stored in session, APC would be useful here too
			$this->persistent->acl = $acl;

		}

		return $this->persistent->acl;

	}

	/**
	 * This action is executed before execute any action in the application
	 *
	 * @param Event $event
	 * @param Dispatcher $dispatcher
	 */
	public function beforeDispatch(Event $event, Dispatcher $dispatcher)
	{


		$auth = $this->session->get('auth');
		if (!$auth){
			$role = 'Guests';
		} elseif($auth['admin']=='Y') {
			$role = 'Admin';
		}
        else{
           $role='Users';
        }

		$controller = $dispatcher->getControllerName();


		$action = $dispatcher->getActionName();


		$acl = $this->getAcl();

		$allowed = $acl->isAllowed($role, $controller, $action);



		if ($allowed != Acl::ALLOW) {
			$dispatcher->forward(array(
				'controller' => 'errors',
				'action'     => 'show401'
			));
			return false;
		}

	}

}
