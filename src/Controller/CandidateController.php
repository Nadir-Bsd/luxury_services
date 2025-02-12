<?php

namespace App\Controller;

use App\Entity\Candidate;
use App\Form\CandidateType;
use App\Interfaces\FileHandlerInterface;
use App\Repository\CandidateRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/candidate')]
final class CandidateController extends AbstractController
{
    #[Route(name: 'app_candidate', methods: ['GET'])]
    public function index(CandidateRepository $candidateRepository): Response
    {
        return $this->render('candidate/index.html.twig', [
            'candidates' => $candidateRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_candidate_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $candidate = new Candidate();
        $form = $this->createForm(CandidateType::class, $candidate);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($candidate);
            $entityManager->flush();

            return $this->redirectToRoute('app_candidate_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('candidate/new.html.twig', [
            'candidate' => $candidate,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_candidate_show', methods: ['GET'])]
    public function show(Candidate $candidate): Response
    {
        return $this->render('candidate/show.html.twig', [
            'candidate' => $candidate,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_candidate_edit', methods: ['GET', 'POST'])]
    public function edit(int $id, Request $request ,EntityManagerInterface $entityManager, FileHandlerInterface $fileHandler): Response
    {
        $candidate = $entityManager->getRepository(Candidate::class)->findOneBy(['User' => $id]);

        $form = $this->createForm(CandidateType::class, $candidate);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {

            // the input files who's need to be checked
            $files = [
                'pp' => $form->get('file_pp')->getData(),
                'passport' => $form->get('file_passport')->getData(),
                'cv' => $form->get('file_cv')->getData(),
            ];
            // get files, for each file, then set Candidate property with the new file name
            $fileHandler->handleFiles($candidate, $files);


            $entityManager->persist($candidate);
            $entityManager->flush();

            $this->addFlash('success', 'Candidate updated successfully!');
        }

        return $this->render('candidate/index.html.twig', [
            'candidate' => $candidate,
            'form' => $form,            
            'OriginalfilePassportName' => $this->getOriginalFilename($candidate->getFilePassport()),
            'OriginalfileCvName' => $this->getOriginalFilename($candidate->getFileCv()),
            'OriginalfilePpName' => $this->getOriginalFilename($candidate->getFilePp()),
        ]);
    }

    #[Route('/{id}', name: 'app_candidate_delete', methods: ['POST'])]
    public function delete(Request $request, Candidate $candidate, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$candidate->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($candidate);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_candidate_index', [], Response::HTTP_SEE_OTHER);
    }

    private function getOriginalFilename(?string $filename): ?string
    {
        return $filename ? preg_replace('/-\w{13}(?=\.\w{3,4}$)/', '', $filename) : null;
    }
}
