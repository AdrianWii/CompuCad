<?php

namespace AppBundle\Service;

use Doctrine\ORM\EntityManager;

/**
 * Description of DoctrineService
 *
 * @author adrian
 */
class DoctrineService {

    protected $manager;

    public function __construct(EntityManager $manager) {
        $this->manager = $manager;
    }

    public function getRepositories() {
        $result = $this->manager->getRepository('AppBundle:Excercise')->findAll();
                    
        return array('result'=>$result);
    }

}
