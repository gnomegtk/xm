<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\SearchHistorical;
use App\Entity\SearchHistoricalGateway;
use App\Form\SearchHistoricalType;
use DateTime;
use Swift_Mailer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    /**
     * @var Swift_Mailer
     */
    private $mailer;

    /**
     * DefaultController constructor.
     *
     * @param Swift_Mailer $mailer
     */
    public function __construct(Swift_Mailer $mailer)
    {
        $this->mailer = $mailer;
    }

    /**
     * @Route("/index")
     *
     * @param Request $request
     *
     * @param SearchHistoricalGateway $searchHistoricalGateway
     * @return Response
     */
    public function index(Request $request, SearchHistoricalGateway $searchHistoricalGateway): Response
    {
        $search = new SearchHistorical();

        /** @var Form $form */
        $form = $this->createForm(SearchHistoricalType::class, $search);

        $results = [];
        $formSubmitted = false;

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $data          = $form->getData();
            $companySymbol = $data->getCompanySymbol();
            $startDate     = $data->getStartDate();
            $endDate       = $data->getEndDate();
            $email         = $data->getEmail();

            $results = $searchHistoricalGateway->getHistorical($companySymbol, $startDate, $endDate);

            $this->sendEmail($companySymbol, $startDate, $endDate, $email);

            $formSubmitted = true;
        }

        return $this->render('default/index.html.twig', [
            'form'          => $form->createView(),
            'formSubmitted' => $formSubmitted,
            'results'       => $results
        ]);
    }

    /**
     * @param string $companyName
     * @param DateTime $startDate
     * @param DateTime $endDate
     * @param string $email
     */
    private function sendEmail(
        string $companyName,
        DateTime $startDate,
        DateTime $endDate,
        string $email
    ): void {
        $message = (new \Swift_Message($companyName))
            ->setFrom('send@example.com')
            ->setTo($email)
            ->setBody('From ' . $startDate->getTimestamp() . ' to ' . $endDate->getTimestamp());

        $this->mailer->send($message);
    }
}