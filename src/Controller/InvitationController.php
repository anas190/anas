<?php

namespace App\Controller;

use App\Entity\Invitation;
use App\Form\InvitationType;
use App\Form\InvitationType1;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Mailer\MailerInterface;

/**
 * @Route("/invitation")
 */
class InvitationController extends AbstractController
{
    /**
     * @Route("/", name="app_invitation_index", methods={"GET"})
     */
    public function index(EntityManagerInterface $entityManager): Response
    {
        $invitations = $entityManager
            ->getRepository(Invitation::class)
            ->findAll();

        return $this->render('invitation/index.html.twig', [
            'invitations' => $invitations,
        ]);
    }

    /**
     * @Route("/new", name="app_invitation_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager, MailerInterface $mailer): Response
    {
        $to = 'anaslamiri07@gmail.com';
        $sjt = 'Demande de joindre equipe';
        $text = 'je demande de joidre votre equpe svp ! ';
        $invitation = new Invitation();
        $form = $this->createForm(InvitationType1::class, $invitation);
        $form->handleRequest($request);
$invitation->setEtat('Non consulté');
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($invitation);
            $entityManager->flush();
            $mail = new MailerController();
            $mail->sendEmail($mailer, $to, $sjt, $text);
            return $this->redirectToRoute('app_invitation_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('invitation/new.html.twig', [
            'invitation' => $invitation,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{idInvitation}", name="app_invitation_show", methods={"GET"})
     */
    public function show(Invitation $invitation): Response
    {
        return $this->render('invitation/show.html.twig', [
            'invitation' => $invitation,
        ]);
    }

    /**
     * @Route("/{idInvitation}/edit", name="app_invitation_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Invitation $invitation, EntityManagerInterface $entityManager, MailerInterface $mailer): Response
    {
        $form = $this->createForm(InvitationType::class, $invitation);
        $form->handleRequest($request);

        $etat=$form->getData('etat');
        $to = 'anaslamiri07@gmail.com';
        $sjt = 'Etat d invitation de  joindre equipe';
        $text = "votre Demande est " .$etat;
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            $mail = new MailerController();
            $mail->sendEmail($mailer, $to, $sjt, $text);
            return $this->redirectToRoute('app_invitation_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('invitation/edit.html.twig', [
            'invitation' => $invitation,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{idInvitation}", name="app_invitation_delete", methods={"POST"})
     */
    public function delete(Request $request, Invitation $invitation, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $invitation->getIdInvitation(), $request->request->get('_token'))) {
            $entityManager->remove($invitation);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_invitation_index', [], Response::HTTP_SEE_OTHER);
    }
}
