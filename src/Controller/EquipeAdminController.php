<?php

namespace App\Controller;

use App\Entity\Equipe;
use App\Entity\Invitation;
use App\Form\Equipe1Type;
use App\Service\T_HTML2PDF;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/equipeadmin")
 */
class EquipeAdminController extends AbstractController
{
    /**
     * @Route("/", name="app_equipe_admin_index", methods={"GET"})
     */
    public function index(EntityManagerInterface $entityManager): Response
    {
     
        
        $equipes = $entityManager
            ->getRepository(Equipe::class)
            ->findAll();
            $list=[];
            foreach ($equipes as $i)
            {$nb=$this->nb($i->getIdEquipe());
            
            $list[$i->getIdEquipe()]=$nb;
            
            }
    
        return $this->render('equipe_admin/index.html.twig', [
            'equipes' => $equipes,
            'nbinv'=>$list
        ]);
    }

function nb($id)
{ $entityManager=$this->getDoctrine()->getManager();
    
    $invitations=$entityManager
    ->getRepository(Invitation::class)
    ->findAll();
    $nb=0;
    foreach ($invitations as $i)
    {if($i->getIdEq()->getIdEquipe()==$id)
        {$nb=$nb+1;}


    }
    return $nb;


}

    /**
     * @Route("/equipe_pdf", name="equipe_pdf", methods={"GET"})
     */
    public function showPdf(EntityManagerInterface $entityManager): Response
    {
        $equipes = $entityManager
            ->getRepository(Equipe::class)
            ->findAll();
        $datee = new \DateTime('@' . strtotime('now'));;

        $template = $this->render('equipe_admin/print.html.twig', [
            'equipes' => $equipes,
            'datee' => $datee

        ]);
        $html2pdf = new T_HTML2PDF('P', 'A4', 'fr', true, 'UTF-8', array(10, 15, 10, 15));
        $html2pdf->create('P', 'A4', 'fr', true, 'UTF-8', array(10, 15, 10, 15));
        return $html2pdf->generatePdf($template, "facture");
    }

    /**
     * @Route("/new", name="app_equipe_admin_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $equipe = new Equipe();
        $form = $this->createForm(Equipe1Type::class, $equipe);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($equipe);
            $entityManager->flush();

            return $this->redirectToRoute('app_equipe_admin_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('equipe_admin/new.html.twig', [
            'equipe' => $equipe,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{idEquipe}", name="app_equipe_admin_show", methods={"GET"})
     */
    public function show(Equipe $equipe): Response
    {
        return $this->render('equipe_admin/show.html.twig', [
            'equipe' => $equipe,
        ]);
    }

    /**
     * @Route("/{idEquipe}/edit", name="app_equipe_admin_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Equipe $equipe, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(Equipe1Type::class, $equipe);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_equipe_admin_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('equipe_admin/edit.html.twig', [
            'equipe' => $equipe,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{idEquipe}", name="app_equipe_admin_delete", methods={"POST"})
     */
    public function delete(Request $request, Equipe $equipe, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $equipe->getIdEquipe(), $request->request->get('_token'))) {
            $entityManager->remove($equipe);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_equipe_admin_index', [], Response::HTTP_SEE_OTHER);
    }
    /**
     * @Route("/", name="app_equipe_recherche", methods={"POST"})
     */
    public function rechercher(Request $request)
    {
        $em = $this-> getDoctrine()->getManager();
        $equipes=$em->getRepository(Equipe::class)->findall();
        $list=[];
        foreach ($equipes as $i)
        {$nb=$this->nb($i->getIdEquipe());
        
        $list[$i->getIdEquipe()]=$nb;
        
        }
        if( $request->isMethod("POST"))
        {
            $nomequipe =$request->get('nomEquipe');
            $equipes =$em->getRepository("App:Equipe")->findBy(array('nomEquipe'=>$nomequipe));
        

        }
        return $this->render('equipe_admin/index.html.twig', [
            'equipes' => $equipes,
            'nbinv'=>$list
        ]);
    }
}
