<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\User;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Doctrine\Common\Collections\ArrayCollection;
use AppBundle\Entity\User as Users;

class UserController extends Controller {

    /**
     * @Route("/login", name="login")
     * 
     * @Template
     */
    public function loginAction(Request $request) {
        $authenticationUtils = $this->get('security.authentication_utils');

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return array(
            'last_username' => $lastUsername,
            'error' => $error,
        );
    }

    /**
     * @Route("/details", name="user_detail")
     * 
     * @Template
     */
    public function detailsAction(Request $request) {
        $courses = new \AppBundle\Entity\Courses();
        $user = $this->get('security.token_storage')->getToken()->getUser();

        #return new Response('Well hi there '.$user->getUsername());

        $form = $this->createFormBuilder()
                ->add('course', TextType::class, array('label' => 'Nazwa', 'attr' => array('class' => 'form-control', 'style' => 'margin-bottom:15px')))
                ->add('save', SubmitType::class, array('label' => 'Utwórz', 'attr' => array('class' => 'btn btn-default btn-block', 'style' => 'margin-bottom:15px')))
                ->getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            //Get Data
            $newCourse = $form['course']->getData();

            $courses->setCourse($newCourse);

            $em = $this->getDoctrine()->getManager();
            $em->persist($courses);
            $em->flush();

            $this->addFlash(
                    'notice', 'Kurs został utworzony!'
            );
            return $this->redirectToRoute('user_detail');
        }

        return array('user' => $user, 'form' => $form->createView());
    }

    /**
     * @Route("/register", name="user_register")
     * 
     * @Template
     */
    public function registerAction(Request $request) {


        $user = new User;

        $form = $this->createFormBuilder($user)
                ->add('username', TextType::class, array('label' => 'Login', 'attr' => array('class' => 'form-control', 'style' => 'margin-bottom:15px')))
                ->add('password', TextType::class, array('label' => 'Hasło', 'attr' => array('class' => 'form-control', 'style' => 'margin-bottom:15px')))
                ->add('email', TextType::class, array('label' => 'E-mail', 'attr' => array('class' => 'form-control', 'style' => 'margin-bottom:15px')))
                ->add('name', TextType::class, array('label' => 'Imię', 'attr' => array('class' => 'form-control', 'style' => 'margin-bottom:15px')))
                ->add('surname', TextType::class, array('label' => 'Nazwisko', 'attr' => array('class' => 'form-control', 'style' => 'margin-bottom:15px')))
                ->add('phone', TextType::class, array('label' => 'Telefon', 'attr' => array('class' => 'form-control', 'style' => 'margin-bottom:15px')))
                ->add('save', SubmitType::class, array('label' => 'Zarejestruj użytkownika', 'attr' => array('class' => 'btn btn-primary', 'style' => 'margin-bottom:15px')))
                ->getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            //Get Data
            $username = $form['username']->getData();
            $password = $form['password']->getData();
            $email = $form['email']->getData();
            $name = $form['name']->getData();
            $surname = $form['surname']->getData();
            $phone = $form['phone']->getData();

            $is_active = 1;

            $encoder = $this->container->get('security.password_encoder');
            $encoded = $encoder->encodePassword($user, $password);


            $user->setUsername($username);
            $user->setPassword($encoded);
            $user->setEmail($email);
            $user->setName($name);
            $user->setSurname($surname);
            $user->setPhone($phone);
            $user->setIsActive($is_active);

            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            $this->addFlash(
                    'notice', 'Użytkownik zarejestrowany poprawnie!'
            );
            return $this->redirectToRoute('homepage');
        }
        return array('form' => $form->createView());
    }

    /**
     * @Route("/userupdate", name="user_update")
     * 
     * @Template
     */
    public function updateAction(Request $request) {

        $user = $this->getUser();

        $form = $this->createFormBuilder($user)
                ->add('username', TextType::class, array('label' => 'Login', 'attr' => array('class' => 'form-control', 'style' => 'margin-bottom:15px')))
                ->add('password', PasswordType::class, array('label' => 'Hasło', 'attr' => array('class' => 'form-control', 'style' => 'margin-bottom:15px')))
                ->add('email', TextType::class, array('label' => 'E-mail', 'attr' => array('class' => 'form-control', 'style' => 'margin-bottom:15px')))
                ->add('name', TextType::class, array('label' => 'Imię', 'attr' => array('class' => 'form-control', 'style' => 'margin-bottom:15px')))
                ->add('surname', TextType::class, array('label' => 'Nazwisko', 'attr' => array('class' => 'form-control', 'style' => 'margin-bottom:15px')))
                ->add('phone', TextType::class, array('label' => 'Telefon', 'attr' => array('class' => 'form-control', 'style' => 'margin-bottom:15px')))
                ->add('save', SubmitType::class, array('label' => 'Aktualizuj dane', 'attr' => array('class' => 'btn btn-primary', 'style' => 'margin-bottom:15px')))
                ->getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            //Get Data
            $username = $form['username']->getData();
            $password = $form['password']->getData();
            $email = $form['email']->getData();
            $name = $form['name']->getData();
            $surname = $form['surname']->getData();
            $phone = $form['phone']->getData();

            $is_active = 1;

            $encoder = $this->container->get('security.password_encoder');
            $encoded = $encoder->encodePassword($user, $password);


            $user->setUsername($username);
            $user->setPassword($encoded);
            $user->setEmail($email);
            $user->setName($name);
            $user->setSurname($surname);
            $user->setPhone($phone);
            $user->setIsActive($is_active);

            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            $this->addFlash(
                    'notice', 'Dane zaktualizowane!'
            );
            return $this->redirectToRoute('homepage');
        }
        return array('form' => $form->createView());
    }

    /**
     * @Route("/userupdate/{id}", name="user_update_2")
     * 
     */
    public function updateByIDAction(Request $request, $id) {

        $user = $this->getDoctrine()->getRepository('AppBundle:User')
        ->find($id);
                
        $form = $this->createFormBuilder($user)
                ->add('username', TextType::class, array('label' => 'Login', 'attr' => array('class' => 'form-control', 'style' => 'margin-bottom:15px')))
                ->add('password', PasswordType::class, array('label' => 'Hasło', 'attr' => array('class' => 'form-control', 'style' => 'margin-bottom:15px')))
                ->add('email', TextType::class, array('label' => 'E-mail', 'attr' => array('class' => 'form-control', 'style' => 'margin-bottom:15px')))
                ->add('name', TextType::class, array('label' => 'Imię', 'attr' => array('class' => 'form-control', 'style' => 'margin-bottom:15px')))
                ->add('surname', TextType::class, array('label' => 'Nazwisko', 'attr' => array('class' => 'form-control', 'style' => 'margin-bottom:15px')))
                ->add('phone', TextType::class, array('label' => 'Telefon', 'attr' => array('class' => 'form-control', 'style' => 'margin-bottom:15px')))
                ->add('save', SubmitType::class, array('label' => 'Aktualizuj dane', 'attr' => array('class' => 'btn btn-primary', 'style' => 'margin-bottom:15px')))
                ->getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            //Get Data
            $username = $form['username']->getData();
            $password = $form['password']->getData();
            $email = $form['email']->getData();
            $name = $form['name']->getData();
            $surname = $form['surname']->getData();
            $phone = $form['phone']->getData();

            $is_active = 1;

            $encoder = $this->container->get('security.password_encoder');
            $encoded = $encoder->encodePassword($user, $password);


            $user->setUsername($username);
            $user->setPassword($encoded);
            $user->setEmail($email);
            $user->setName($name);
            $user->setSurname($surname);
            $user->setPhone($phone);
            $user->setIsActive($is_active);

            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            $this->addFlash(
                    'notice', 'Dane zaktualizowane!'
            );
            return $this->redirectToRoute('homepage');
        }
          return $this->render('AppBundle:User:update.html.twig', array('form' => $form->createView()));
    }
    
    /**
     * @Route("/manage", name="user_manage")
     * 
     * @Template
     */
    public function manageAction(Request $request) {
        $users = $this->getDoctrine()->getRepository('AppBundle:User')
                ->findAll();

        return array(
            'users' => $users
        );
    }
    
    /**
     * @Route("/deleteuser/{id}", name="user_delete")
     */
    public function deleteAction($id) {

        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository('AppBundle:User')->find($id);
        $em->remove($user);
        $em->flush();

        $this->addFlash(
                'notice', 'Użytkownik usunięty!'
        );

        return $this->redirectToRoute('user_manage');
    }

}
