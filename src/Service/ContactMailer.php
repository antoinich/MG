<?php


namespace App\Service;


use App\Entity\Contact;
use phpDocumentor\Reflection\Types\Context;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mime\Address;

class ContactMailer
{
    private $mailer;

    public function __construct(MailerInterface $mailer)
    {
       $this->mailer = $mailer;
    }

    public function sendEmail(Contact $contact)
    {
        $email = (new TemplatedEmail())
            ->from($contact->getEmail())
            ->to('antoinejen@hotmail.com')
            ->subject('Demande de renseignements')
            ->text($contact->getMessage())
            ->htmlTemplate('email/demande.html.twig')
            ->Context([
                'nom'=>$contact->getName(),
                'prenom'=> $contact->getFirstName(),
                'from' => $contact->getEmail(),
                'text' => $contact->getMessage(),
                'phone' => $contact->getPhone()
            ]);



        $this->mailer->send($email);

    }
}