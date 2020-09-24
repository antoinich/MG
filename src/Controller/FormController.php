<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactType;
use App\Service\ContactMailer;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class FormController extends AbstractController
{
    /**
     * @Route("/contact", name="app_form")
     */

    public function new(Request $request, EntityManagerInterface $em, ContactMailer $mailer)
    {
        $contact = new Contact();
        /*$contact->setName('Doe');
        $contact->setFirstName('john');
        $contact->setEmail('john@doe.fr');
        $contact->setPhone('0203010405');
        $contact->setMessage('coucou');*/

        $form = $this->createForm(ContactType::class, $contact);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $mailer->sendEmail($contact);

            $contact = $form->getData();
            $em->persist($contact);
            $em->flush();
            $this->addFlash('success', 'Votre message à bien été envoyé');
            //return $this->redirectToRoute('app_home');
        }

        return $this->render('form/index.html.twig', [
            'form' => $form->createView(),
        ]);

    }
}
