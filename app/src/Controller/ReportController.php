<?php
/**
 * Report controller.
 */

namespace App\Controller;

use App\Entity\Report;
use App\Form\Type\ReportType;
use App\Repository\ReportRepository;
use App\Service\ReportService;
use App\Service\ReportServiceInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * Class ReportController.
 */
#[Route('/report')]
class ReportController extends AbstractController
{
    /**
     * Report service.
     */
    private ReportServiceInterface $reportService;

    /**
     * Translator.
     */
    private TranslatorInterface $translator;

    /**
     * Constructor.
     */
    public function __construct(ReportServiceInterface $reportService, TranslatorInterface $translator)
    {
        $this->reportService = $reportService;
        $this->translator = $translator;
    }

    /**
     * Index action.
     *
     * @param Request $request HTTP Request
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
     * @param Report $report Report entity
     *
     * @return Response HTTP response
     */
    #[Route(
        '/{id}',
        name: 'report_show',
        requirements: ['id' => '[1-9]\d*'],
        methods: 'GET',
    )]
    public function show(Report $report): Response
    {
        return $this->render(
            'report/show.html.twig',
            ['report' => $report]
        );
    }

    /**
     * Create action.
     *
     * @param Request $request HTTP request
     *
     * @return Response HTTP response
     */
    #[Route('/create', name: 'report_create', methods: 'GET|POST', )]
    public function create(Request $request): Response
    {
        $report = new Report();
        $form = $this->createForm(
            ReportType::class,
            $report,
            ['action' => $this->generateUrl('report_create')]
        );
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->reportService->save($report);

            $this->addFlash(
                'success',
                $this->translator->trans('message.created_successfully')
            );

            return $this->redirectToRoute('report_index');
        }

        return $this->render('report/create.html.twig',  ['form' => $form->createView()]);
    }

    /**
     * Edit action.
     *
     * @param Request $request HTTP request
     * @param Report $report Report entity
     *
     * @return Response HTTP response
     */
    #[Route('/{id}/edit', name: 'report_edit', requirements: ['id' => '[1-9]\d*'], methods: 'GET|PUT')]
    public function edit(Request $request, Report $report): Response
    {
        $form = $this->createForm(
            ReportType::class,
            $report,
            [
                'method' => 'PUT',
                'action' => $this->generateUrl('report_edit', ['id' => $report->getId()]),
            ]
        );
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->reportService->save($report);

            $this->addFlash(
                'success',
                $this->translator->trans('message.edited_successfully')
            );

            return $this->redirectToRoute('report_index');
        }

        return $this->render(
            'report/edit.html.twig',
            [
                'form' => $form->createView(),
                'report' => $report,
            ]
        );
    }
    /**
     * Delete action.
     *
     * @param Request $request HTTP request
     * @param Report $report Report entity
     *
     * @return Response HTTP response
     */
    #[Route('/{id}/delete', name: 'report_delete', requirements: ['id' => '[1-9]\d*'], methods: 'GET|DELETE')]
    public function delete(Request $request, Report $report): Response
    {
        $form = $this->createForm(
            FormType::class,
            $report,
            [
                'method' => 'DELETE',
                'action' => $this->generateUrl('report_delete', ['id' => $report->getId()]),
            ]
        );
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->reportService->delete($report);

            $this->addFlash(
                'success',
                $this->translator->trans('message.deleted_successfully')
            );

            return $this->redirectToRoute('report_index');
        }

        return $this->render(
            'report/delete.html.twig',
            [
                'form' => $form->createView(),
                'report' => $report,
            ]
        );
    }
}
