<?php

namespace App\Controller;

use App\Form\ReportType;
use App\Services\MailerHelper;
use App\Services\ReportsService;
use App\Services\XMLParser;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ReportsController
 * @package App\Controller
 */
class ReportsController extends AbstractController
{
    /** @var ReportsService */
    private $reportsService;

    /** @var XMLParser */
    private $xmlParser;

    /** @var MailerHelper */
    private $mailerHelper;

    /**
     * ReportsController constructor.
     * @param ReportsService $reportsService
     * @param XMLParser $xmlParser
     */
    public function __construct(
        ReportsService $reportsService, XMLParser $xmlParser, MailerHelper $mailerHelper
    )
    {
        $this->reportsService = $reportsService;
        $this->xmlParser = $xmlParser;
        $this->mailerHelper = $mailerHelper;
    }

    /**
     * @Route("/", name="reports_list")
     */
    public function index()
    {
        $reports = $this->reportsService->getAllReports();

        return $this->render('reports/index.html.twig', [
            'reports' => $reports
        ]);
    }

    /**
     * @Route("/upload", name="reports_upload")
     * @param Request $request
     * @return Response
     * @throws \Symfony\Component\Mailer\Exception\TransportExceptionInterface
     */
    public function create(Request $request)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $form = $this->createForm(ReportType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            /** @var UploadedFile */
            $file = $form['file']->getData();
            $fileName = $file->getClientOriginalName();
            $file->move($this->getParameter('uploads_dir'), $fileName);

            $reportAttributes = $this->xmlParser->getReportAttributes(
                $this->getParameter('uploads_dir') . DIRECTORY_SEPARATOR . $fileName
            );

            $report = $this->reportsService->saveReportData($this->getUser(), $reportAttributes, $fileName);
            $this->mailerHelper->sendSuccessMessage($this->getUser(), $report);
            $this->addFlash('success', 'Вы успешно подали отчет в системе reports.com');

            return $this->redirectToRoute('reports_list');
        }

        if ($form['file']->getErrors()) {
            $errors = $form['file']->getErrors(true);
            $this->mailerHelper->sendErrorMessage($this->getUser(), $errors);
        }

        return $this->render('reports/upload.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
