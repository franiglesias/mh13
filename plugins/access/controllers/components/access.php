<?php
/**
 *  Access Component.
 *
 *  Created on Wed Jun  2 23:14:29 CEST 2010.
 **/
App::import('Model', 'Access.Permission');
App::import('Model', 'Access.User');
App::import('Lib', 'Access.AccessResource');

class AccessComponent extends Object
{
    // The initialize method is called before the controller's beforeFilter method.
    public $Controller;
    public $User;
    public $ResourceFactory;

    public $components = array(
        'Auth', 'Session',
        );

    public function initialize(&$controller, $settings = array())
    {
        $this->Controller = $controller;
        $this->User = ClassRegistry::init('User');
        $this->User->getActive($this->Auth->user('username'));
        $this->ResourceFactory = new ResourceFactory();
    }

    public function user()
    {
        return $this->User;
    }

    public function isAuthorized(AccessResource $Resource)
    {
        $result = $this->isAllowed($Resource, $this->User);
        if (!$result) {
            $this->log(
                sprintf('User %s is not authorized to %s', $this->User->getName(), $Resource->value()),
                'access'
            );

            return false;
        }
        $this->log(
            sprintf('User %s has access to %s', $this->User->getName(), $Resource->value()),
            'access'
        );

        return true;
    }

    private function isAllowed(AccessResource $Resource, User $User)
    {
        $joins = array(
            array(
                'table' => 'roles_users',
                'alias' => 'RolesUser',
                'type' => 'left',
                'conditions' => array('RolesUser.user_id = User.id'),
            ),
            array(
                'table' => 'permissions_roles',
                'alias' => 'PermissionsRole',
                'type' => 'left',
                'conditions' => array('PermissionsRole.role_id = RolesUser.role_id'),
            ),
            array(
                'table' => 'permissions',
                'alias' => 'Permission',
                'type' => 'left',
                'conditions' => array('PermissionsRole.permission_id = Permission.id'),
            ),
        );
        $conditions = array(
            '"'.$Resource->value().'" LIKE Permission.url_pattern',
            'PermissionsRole.access' => true,
            'User.id' => $User->getID(),
        );

        return $User->find('count', compact('joins', 'conditions'));
    }

    public function getResource($token)
    {
        return $this->ResourceFactory->make($token);
    }

    public function isAuthorizedToken($token)
    {
        return $this->isAuthorized($this->getResource($token));
    }
}
