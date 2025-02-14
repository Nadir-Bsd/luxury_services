<?php

namespace App\Controller;

use App\Repository\JobRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class JobController extends AbstractController
{
    #[Route('/job', name: 'app_job')]
    public function index(JobRepository $jobRepo): Response
    {
        // get all jobs from database
        $jobs = $jobRepo->findAll();

        return $this->render('job/index.html.twig', [
            // send array of data for job cards
            'jobs' => $jobs,
        ]);
    }



    #[Route('/job/{slug}', name: 'app_job_show')]
    public function show(): Response
    {
        return $this->render('job/show.html.twig', [
        ]);
    }
}
