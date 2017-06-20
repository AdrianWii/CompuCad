<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace AppBundle\Controller;

use AppBundle\Entity\Todo;
use AppBundle\Entity\Courses;
use AppBundle\Entity\Excercise;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Form\Type\RegisterType;
use Symfony\Component\Validator\Constraints as Assert;

class TodoController extends Controller {
    /*
     * The method shown to create the controller is not the correct way to do this and is teaching bad practices.

      You should use `php bin/console generate:controller` and pass arguments to automatically generate the methods.

      e.g. php bin/console generate:controller --controller=AppBundle:Todo﻿
     * 
     * 
     * Additionally, you should place the views inside of the bundle, the views in the app folder should be system wide, such as global headers, footers, and page wrappers.

      Also, rather than specifying `/todos` at the start of every method, you can apply annotation routing to the class itself, and  all methods will nest under this route.﻿
     */

    /**
     * @Route("/admin")
     */
    public function adminAction() {
        return new Response('<html><body>Admin page!</body></html>');
    }

    /**
     * @Route("/list", name="todo_list")
     * 
     * @Template
     */
    public function listAction() {
//        $todos = $this->getDoctrine()->getRepository('AppBundle:Todo')
//                ->findAll();
//
//        $courses = $this->getDoctrine()->getRepository('AppBundle:Courses')
//                ->findAll();
//
//        return array('todos' => $todos, 'courses' => $courses);

        $excercise = $this->getDoctrine()->getRepository('AppBundle:Excercise')
                ->findAll();

        $courses = $this->getDoctrine()->getRepository('AppBundle:Courses')
                ->findAll();

        return array('excercises' => $excercise, 'courses' => $courses);
    }

    /**
     * @Route("/create", name="todo_create")
     * 
     * @Template
     */
    public function createAction(Request $request) {

//        $todo = new Todo;
//        
//        $form = $this->createFormBuilder($todo)
//                ->add('name', TextType::class, array('attr' => array('class' => 'form-control', 'style' => 'margin-bottom:15px')))
//                ->add('category', TextType::class, array('attr' => array('class' => 'form-control', 'style' => 'margin-bottom:15px')))
//                ->add('description', TextareaType::class, array('attr' => array('class' => 'form-control', 'style' => 'margin-bottom:15px')))
//                ->add('priority', ChoiceType::class, array('choices' => array('Low' => 'Low', 'Medium' => 'Medium', 'High' => 'High'), 'attr' => array('class' => 'form-control', 'style' => 'margin-bottom:15px')))
//                ->add('due_date', DateTimeType::class, array('attr' => array('class' => 'formcontrol', 'style' => 'margin-bottom:15px')))
//                ->add('save', SubmitType::class, array('label' => 'Create Todo', 'attr' => array('class' => 'btn btn-primary', 'style' => 'margin-bottom:15px')))
//                ->getForm();
//
//        $form->handleRequest($request);
//        if ($form->isSubmitted() && $form->isValid()) {
//            //Get Data
//            $name = $form['name']->getData();
//            $category = $form['category']->getData();
//            $description = $form['description']->getData();
//            $priority = $form['priority']->getData();
//            $due_date = $form['due_date']->getData();
//
//            $now = new\DateTime('now');
//            $todo->setName($name);
//            $todo->setCategory($category);
//            $todo->setDescription($description);
//            $todo->setPriority($priority);
//            $todo->setDueDate($due_date);
//            $todo->setCreateDate($now);
//
//            $em = $this->getDoctrine()->getManager();
//            $em->persist($todo);
//            $em->flush();
//
//            $this->addFlash(
//                    'notice', 'todo added'
//            );
//            return $this->redirectToRoute('todo_list');
        
        $excercise = new Excercise();
        $form = $this->createFormBuilder($excercise)
                ->add('excercise', TextType::class, array('label'=>'Polecenie:', 'attr' => array('class' => 'form-control', 'style' => 'margin-bottom:15px')))
                ->add('save', SubmitType::class, array('label' => 'Utwórz', 'attr' => array('class' => 'btn btn-primary', 'style' => 'margin-bottom:15px')))
                ->getForm();
        
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            //Get Data
            $name = $form['excercise']->getData();

$excercise->setExcercise($name);

            $em = $this->getDoctrine()->getManager();
            $em->persist($excercise);
            $em->flush();

            $this->addFlash(
                    'notice', 'Ćwiczenie dodane'
            );
            return $this->redirectToRoute('todo_list');
        }
        return array('form' => $form->createView());
    }

    /**
     * @Route("/edit/{id}", name="todo_edit")
     * 
     * @Template
     */
    public function editAction($id, Request $request) {
        $todo = $this->getDoctrine()->getRepository('AppBundle:Todo')
                ->find($id);

        $now = new\DateTime('now');

        $todo->setName($todo->getName());
        $todo->setCategory($todo->getCategory());
        $todo->setDescription($todo->getDescription());
        $todo->setPriority($todo->getPriority());
        $todo->setDueDate($todo->getDueDate());
        $todo->setCreateDate($now);

        $form = $this->createFormBuilder($todo)
                ->add('name', TextType::class, array('attr' => array('class' => 'form-control', 'style' => 'margin-bottom:15px')))
                ->add('category', TextType::class, array('attr' => array('class' => 'form-control', 'style' => 'margin-bottom:15px')))
                ->add('description', TextareaType::class, array('attr' => array('class' => 'form-control', 'style' => 'margin-bottom:15px')))
                ->add('priority', ChoiceType::class, array('choices' => array('Low' => 'Low', 'Medium' => 'Medium', 'High' => 'High'), 'attr' => array('class' => 'form-control', 'style' => 'margin-bottom:15px')))
                ->add('due_date', DateTimeType::class, array('attr' => array('class' => 'formcontrol', 'style' => 'margin-bottom:15px')))
                ->add('save', SubmitType::class, array('label' => 'Aktualizuj', 'attr' => array('class' => 'btn btn-primary', 'style' => 'margin-bottom:15px')))
                ->getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            //Get Data
            $name = $form['name']->getData();
            $category = $form['category']->getData();
            $description = $form['description']->getData();
            $priority = $form['priority']->getData();
            $due_date = $form['due_date']->getData();

            $now = new\DateTime('now');

            $em = $this->getDoctrine()->getManager();
            $todo = $em->getRepository('AppBundle:Todo')->find($id);

            $todo->setName($name);
            $todo->setCategory($category);
            $todo->setDescription($description);
            $todo->setPriority($priority);
            $todo->setDueDate($due_date);
            $todo->setCreateDate($now);


            $em->flush();

            $this->addFlash(
                    'notice', 'Ćwiczenie zaktualizowane'
            );
            return $this->redirectToRoute('todo_list');
        }
        return array('todo' => $todo, 'form' => $form->createView());
    }

    /**
     * @Route("/todo/details/{id}", name="todo_details")
     */
    public function detailsAction($id) {

        $todo = $this->getDoctrine()->getRepository('AppBundle:Todo')
                ->find($id);

        return $this->render('todo/details.html.twig', array('todo' => $todo));
    }

    /**
     * @Route("/delete/{id}", name="todo_delete")
     */
    public function deleteAction($id) {

        $em = $this->getDoctrine()->getManager();
        $todo = $em->getRepository('AppBundle:Excercise')->find($id);
        $em->remove($todo);
        $em->flush();

        $this->addFlash(
                'notice', 'Ćwiczenie usunięte!'
        );

        return $this->redirectToRoute('todo_list');
    }

    /**
     * @Route("/", name="root")
     */
    public function indexAction() {
        return $this->render('default/index.html.twig');
    }

    /**
     * @Route("/learn", name="todo_learn")
     * 
     * @Template
     */
    public function learnAction() {
        return array();
    }

    /**
     * @Route("/excercise", name="todo_excercise")
     * 
     */
    public function createExcerciseAction() {
        $course = new Courses();
        $course->setCourse('AutoCAD III');

        $excercise = new Excercise();
        $excercise->setExcercise('ĆWICZENIE TESTOWE');

        // relate this product to the category
        $excercise->setCourses($course);

        $em = $this->getDoctrine()->getManager();
        $em->persist($course);
        $em->persist($excercise);
        $em->flush();

        return new Response(
                'Saved new excercise with id: ' . $excercise->getId()
                . ' and new course with id: ' . $course->getId()
        );
    }

    /**
     * @Route("/update/{id}", name="todo_update")
     * 
     * @Template
     */
    public function updateAction($id, Request $request) {
        $excercise = $this->getDoctrine()->getRepository('AppBundle:Excercise')
                ->find($id);

        $excercise->setExcercise($excercise->getExcercise());

        $form = $this->createFormBuilder($excercise)
                ->add('excercise', TextType::class, array('label' => 'polecenie', 'attr' => array('class' => 'form-control', 'style' => 'margin-bottom:15px')))
//                ->add('image', FileType::class, array(
//                    'label' => 'przykład'
//                    ))
                ->add('save', SubmitType::class, array('label' => 'Aktualizuj', 'attr' => array('class' => 'btn btn-primary', 'style' => 'margin-bottom:15px')))
                ->getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            //Get Data
            $ex_name = $form['excercise']->getData();


            $em = $this->getDoctrine()->getManager();
            $excercise = $em->getRepository('AppBundle:Excercise')->find($id);

            $excercise->setExcercise($ex_name);

            $em->flush();

            $this->addFlash(
                    'notice', 'Ćwiczenie zaktualizowane'
            );
            return $this->redirectToRoute('todo_list');
        }
        return array('todo' => $excercise, 'form' => $form->createView());
    }

    /**
     * @Route("/example/{id}", name="todo_example")
     * 
     * @Template
     */
    public function exampleAction($id) {

        $excercise = $this->getDoctrine()->getRepository('AppBundle:Excercise')
                ->find($id);

        return array('excercise' => $excercise);
    }

    /**
     * @Route("/autocad", name="todo_autocad")
     * 
     * @Template
     */
    public function autocadAction() {
        return array();
    }

    /**
     * @Route("/send", name="todo_send")
     * 
     * @Template
     */
    public function sendAction(Request $request) {

        $session = $this->get('session');
        $excercise = $this->getDoctrine()->getRepository('AppBundle:Excercise')
                ->findAll();

        $temp = array();
        $temp['---']=0;
        for ($x = 0; $x < count($excercise); $x++) {
            $temp[$excercise[$x]->getExcercise()] =$x+1;
        } 

        if (!$session->has('registered')) {
            $form = $this->createFormBuilder()
                    ->add('excercise', ChoiceType::class, array(
                        'choices' => $temp,
                        'expanded' => false,
                        'multiple' => false,
                        'label' => 'Zadanie',
                        'constraints' => array(
                            new Assert\NotBlank()
                        )
                        ))
                    ->add('comments', TextareaType::class, array(
                        'label' => 'Komentarz'
                    ))
                    ->add('paymentfile', FileType::class, array(
                        'label' => 'Plik z zadaniem',
                        'constraints' => array(
                            new Assert\NotBlank(),
                            new Assert\File(array(
                                'maxSize' => '1M'
                            ))
                        )
                    ))
                    ->add('rules', CheckboxType::class, array(
                        'label' => 'Akceptacja regulaminu',
                        'mapped' => false,
                        'constraints' => array(
                            new Assert\NotBlank()
                        )
                    ))
                    ->add('save', SubmitType::class, array(
                        'label' => 'Prześlij zadanie'
                    ))
                    ->getForm();
            $form->handleRequest($request);

            if ($request->isMethod('POST')) {
                if ($form->isValid()) {

                    $savePath = $this->get('kernel')->getRootDir() . '/../web/uploads/';

                    $data = $form->getData();
                    unset($data['paymentfile']);

                    $randVal = rand(1000, 9999);
                    $dataFileName = sprintf('data_%d.txt', $randVal);

                    file_put_contents($savePath . $dataFileName, print_r($data, TRUE));

                    $file = $form->get('paymentfile')->getData();
                    if (NULL !== $file) {
                        $fileName = sprintf('file_%d.%s', $randVal, $file->guessExtension());
                        $file->move($savePath, $fileName);
                    }

                    $this->get('notification')->addSuccess('Zadanie zostało poprawnie wgrane na serwer');
                    //$session->set('registered', true);
                    return $this->redirect($this->generateUrl('todo_send'));
                } else {
                    $this->get('notification')->addError('Zadanie nie zostało poprawnie przesłane');
                }
            }
        }

        return array(
            'form' => isset($form) ? $form->createView() : NULL,
            'temp' => $temp
        );
    }

    /**
     * @Route("/test", name="todo_test")
     * 
     * @Template
     */
    public function testAction() {
        return array();
    }

    /**
     * @Route("/schedule", name="todo_schedule")
     * 
     * @Template
     */
    public function scheduleAction() {
        return array();
    }

    /**
     * @Route("/message", name="todo_message")
     * 
     * @Template
     */
    public function messageAction(Request $request) {


        $form = $this->createFormBuilder()
                ->add('message', TextareaType::class, array('label' => 'Wiadomość:', 'attr' => array('class' => 'form-control', 'style' => 'margin-bottom:15px')))
                ->add('send', SubmitType::class, array('label' => 'Wyślij', 'attr' => array('class' => 'btn btn-primary pull-right', 'style' => 'margin-bottom:15px')))
                ->getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            //send mail
            //$msgBody = $this->renderView('AppBundle:Email:base.html.twig', array('name' => $register->getName()));
            $message = \Swift_Message::newInstance()
                    ->setSubject('Potwierdzenie uczestnictwa')
                    ->setFrom('adrian.widlak@interia.pl', 'Adrian')
                    //->setTo(array($register->getEmail() => $register->getName()))
                    ->setTo('adrian.widlak@interia.pl', 'Adrian')
                    //->setBody($msgBody, 'text/html');
                    ->setBody('test');

            $this->get('mailer')->send($message);

            $this->addFlash(
                    'notice', 'Wiadomość wysłana'
            );
            return $this->redirectToRoute('todo_message');
        }
        return array('form' => $form->createView());
    }

}
