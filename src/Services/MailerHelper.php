<?php

namespace App\Services;


use App\Entity\Report;
use Carbon\Carbon;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Form\FormErrorIterator;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Class MailerHelper
 * @package App\Services
 */
class MailerHelper
{
    const FROM_ADDRESS = 'support@reports.com';
    const SUCCESS_MESSAGE_SUBJECT = 'Подтверждение подачи отчетности на reports.com';
    const ERROR_MESSAGE_SUBJECT = 'Ошибка при подаче отчета на reports.com';

    /** @var MailerInterface */
    private $mailer;

    /**
     * MailerHelper constructor.
     * @param MailerInterface $mailer
     */
    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }

    /**
     * @param UserInterface $user
     * @param Report $report
     * @throws \Symfony\Component\Mailer\Exception\TransportExceptionInterface
     */
    public function sendSuccessMessage(UserInterface $user, Report $report)
    {
        $email = (new TemplatedEmail())
            ->from(self::FROM_ADDRESS)
            ->to($user->getEmail())
            ->subject(self::SUCCESS_MESSAGE_SUBJECT)
            ->htmlTemplate('emails/success.html.twig')
            ->context([
                'id'    => $report->getId(),
                'date'  => Carbon::now()->toDateTimeString()
            ]);

        $this->mailer->send($email);
    }

    /**
     * @param UserInterface $user
     * @param FormErrorIterator $errors
     * @throws \Symfony\Component\Mailer\Exception\TransportExceptionInterface
     */
    public function sendErrorMessage(UserInterface $user, FormErrorIterator $errors)
    {
        $errorsArr = [];
        foreach ($errors as $error) {
            $errorsArr[] = $error->getMessage();
        }

        $email = (new TemplatedEmail())
            ->from(self::FROM_ADDRESS)
            ->to($user->getEmail())
            ->subject(self::ERROR_MESSAGE_SUBJECT)
            ->htmlTemplate('emails/error.html.twig')
            ->context(['errors' => $errorsArr]);

        $this->mailer->send($email);
    }
}
