<?php

namespace App\Service;

use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mime\Address;

    class SendEmailService
    {
        private MailerInterface $mailer;
        public function __construct(MailerInterface $mailer)
        {
            $this->mailer = $mailer;
        }

        public function send(array $data = []): void
        {
            $senderEmail        = $data['sender_email'];
            $sendername         = $data['sender_name'];
            $recipientEmail     = $data['recipient_email'];
            $subject            = $data['subject'];
            $htmlTemplate       = $data['html_template'];
            $context            = $data['context'];

            $email = new TemplatedEmail();

            $email->from(new Address($senderEmail, $sendername))
                ->to($recipientEmail)
                ->subject($subject)
                ->htmlTemplate($htmlTemplate)
                ->context($context)
            ;

            try 
            {
                $this->mailer->send($email);
            } catch (TransportExceptionInterface $te) 
            {
                throw $te;
            }
        }
    }
