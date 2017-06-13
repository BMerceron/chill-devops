<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;


class TestController extends Controller
{
    public function testAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('AppBundle::test.html.twig');
    }


    /**
     * Export to PDF
     *
     * @Route("/pdf", name="acme_demo_pdf")
     */
    public function pdfAction()
    {
        $html = $this->renderView('AppBundle::testPdf.html.twig');

        $filename = sprintf('test-%s.pdf', date('Y-m-d'));

        return new Reponse(
            $this->get('knp_snappy.pdf')->getOutputFromHtml($html),
            200,
            [
                'Content-Type'        => 'application/pdf',
                'Content-Disposition' => sprintf('attachment; filename="%s"', $filename),
            ]
        );
    }
}