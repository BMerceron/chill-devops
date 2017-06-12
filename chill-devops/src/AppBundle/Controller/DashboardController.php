<?php

namespace AppBundle\Controller;


use AppBundle\Entity\Scenario;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;

class DashboardController extends Controller
{
    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(Request $request)
    {
        $scenario = new Scenario();

        $form = $this->createFormBuilder($scenario)
            ->add('Name', TextType::class)
            ->add('clientStart', IntegerType::class)
            ->add('periodicity', IntegerType::class)
            ->add('clientAdd', IntegerType::class)
            ->add('Load', SubmitType::class, array('label' => 'Load'))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // $form->getData() holds the submitted values
            // but, the original `$task` variable has also been updated
            $scenario = $form->getData();

            // ... perform some action, such as saving the task to the database
            // for example, if Task is a Doctrine entity, save it!
            // $em->persist($task);
            // $em->flush();

            return $this->redirectToRoute('app_dashboard');
        }

        return $this->render('AppBundle:dashboard:index.html.twig', array(
            'form' => $form->createView(),
        ));
    }
}