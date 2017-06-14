<?php

namespace AppBundle\Controller;


use AppBundle\Entity\Scenario;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

class DashboardController extends Controller
{
    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $scenario = new Scenario();
        $form = $this->createFormBuilder($scenario)
            ->add('Name', TextType::class)
            ->add('clientStart', IntegerType::class)
            ->add('periodicity', IntegerType::class)
            ->add('clientAdd', IntegerType::class)
            ->getForm();

        $form->handleRequest($request);


            if ($form->isSubmitted() && $form->isValid()) {

                /*TODO - SEND SIMULATION*/

                /** @var Scenario $scenario */
                $scenario = $form->getData();
                $scenario->setCreatedAt(new \DateTime());
                $scenario->setCost([
                    'month' => 'Jan',
                    'cost' => [
                        'greenCost' => 123,
                        'classicCost' => 456
                    ]
                ]);

                $em->persist($scenario);
                $em->flush();

                return $this->render('AppBundle:dashboard:index.html.twig', array(
                    'form' => $form->createView(),
                    'scenario' => $scenario
                ));
            }

        return $this->render('AppBundle:dashboard:index.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    public function historyAction() {

        $em = $this->getDoctrine()->getManager();

        $scenarios = $em->getRepository('AppBundle:Scenario')->findAll();

        return $this->render('AppBundle:dashboard:history.html.twig', array(
            'scenarios' => $scenarios,
        ));
    }

    public function showAction(Scenario $scenario)
    {
        $deleteForm = $this->createDeleteForm($scenario);

        return $this->render('AppBundle:dashboard:show.html.twig', array(
            'scenario' => $scenario,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    public function editAction(Request $request, Scenario $scenario)
    {
        $deleteForm = $this->createDeleteForm($scenario);
        $editForm = $this->createForm('AppBundle\Form\ScenarioType', $scenario);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid())    {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('scenario_edit', array('id' => $scenario->getId()));
        }

        return $this->render('AppBundle:dashboard:edit.html.twig', array(
            'scenario' => $scenario,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    public function deleteAction(Request $request, Scenario $scenario)
    {
        $em = $this->getDoctrine()->getManager();
        $scenarioRepo = $em->getRepository('AppBundle:Scenario');
        $scenarioToRemove = $scenarioRepo->findOneById($scenario);
        try {
            $em->remove($scenarioToRemove);
            $em->flush();
            $request->getSession()->getFlashBag()->add('success', 'Scenario supprimé');
        } catch (\Doctrine\DBAL\DBALException $e){
        $request->getSession()->getFlashBag()->add('danger', 'Erreur lors de la suppression :'
        . PHP_EOL . $e->getMessage());
        }

        return $this->redirectToRoute('scenario_history');
    }

    private function createDeleteForm(Scenario $scenario)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('scenario_delete', array('id' => $scenario->getId())))
            ->setMethod('DELETE')
            ->getForm()
            ;
    }
}