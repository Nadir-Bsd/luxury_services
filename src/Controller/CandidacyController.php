<?php

namespace App\Controller;

use App\Entity\Candidacy;
use App\Entity\Candidate;
use App\Entity\Job;
use App\Repository\CandidacyRepository;
use App\Repository\CategoryRepository;
use App\Repository\JobRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class CandidacyController extends AbstractController
{

    #[Route('/candidacy', name: 'app_candidacy_show')]
    public function show(CandidacyRepository $candidacyRepo, CategoryRepository $categoryRepo): Response
    {
        /** @var User */
        $user = $this->getUser();

        /** @var Candidate */
        $candidate = $user->getCandidate();

        $candidacies = $candidacyRepo->findBy(['candidate' => $candidate]);
        $categories = $categoryRepo->findAll();
        
        return $this->render('candidacy/show.html.twig', [
            'candidacies' => $candidacies,
            'categories' => $categories,
        ]);
    }

    #[Route('/candidacy/new/{id}', name: 'app_candidacy_new')]
    public function new(int $id, JobRepository $jobRepo, EntityManagerInterface $entityManager): Response
    {
        /** @var User */
        $user = $this->getUser();

        /** @var Candidate */
        $candidate = $user->getCandidate();

        /** @var Job */
        $job = $jobRepo->find($id);

        // make new Candidacy
        $candidacy = new Candidacy();
        $candidacy->setCandidate($candidate);
        $candidacy->setJob($job);

        // send in DB
        $entityManager->persist($candidacy);
        $entityManager->flush();

        return $this->redirectToRoute('app_candidacy_show');
    }
}
