<?php

namespace AppBundle\Service;


use Symfony\Component\HttpFoundation\Session\Session;

/**
 * Description of Notification
 *
 * @author adrian
 */
class NotificationService {
    
    private $session;
    
    public function __construct(Session $session) {
        $this->session = $session;
    }
    public function addMessage($type, $message){
         $this->session->getFlashBag()->add($type, $message);
    }
    public function addSuccess($message){
        $this->addMessage('success', $message);
    }
    
    public function addError($message){
         $this->addMessage('danger', $message);
    }
}
