<?php
/**
 * Report controller.
 */

namespace App\Controller;

use App\Entity\Report;
use App\Repository\ReportRepository;
use App\Service\ReportService;
use App\Service\ReportServiceInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ReportController.
 */
#[Route('/report')]
class ReportController extends AbstractController
{
    /**
     * Task service.
     */
    private ReportServiceInterface $reportService;

    /**
     * Constructor.
     */
    public function __construct(ReportServiceInterface $taskService)
    {
        $this->reportService = $taskService;
    }

    /**
     * Index action.
     *
     * @param Request            $request        HTTP Request
     *
     * @return Response HTTP response
     */
    #[Route(name: 'report_index', methods: 'GET')]
    public function index(Request $request): Response
    {
        $pagination = $this->reportService->getPaginatedList(
            $request->query->getInt('page', 1)
        );

        return $this->render('report/index.html.twig', ['pagination' => $pagination]);
    }

    /**
     * Show action.
     *
     * @param ReportRepository $reportRepository
     * @param int $id
     * @return Response HTTP response
     */
    #[Route(
        '/{id}',
        name: 'report_show',
        requirements: ['id' => '[1-9]\d*'],
        methods: 'GET',
    )]
    public function show(ReportRepository $reportRepository, int $id): Response
    {
        $report = $reportRepository->find($id);

        return $this->render(
            'report/show.html.twig',
            ['report' => $report]
        );
    }
}
