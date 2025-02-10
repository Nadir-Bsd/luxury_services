<?php

namespace App\Controller;

use App\Entity\Candidate;
use App\Form\CandidateType;
use App\Repository\CandidateRepository;
use App\Service\FileUploader;
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
    public function edit(int $id, Request $request ,EntityManagerInterface $entityManager, FileUploader $fileUploader): Response
    {
        $candidate = $entityManager->getRepository(Candidate::class)->findOneBy(['User' => $id]);

        $form = $this->createForm(CandidateType::class, $candidate);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            // dd($candidate);
            $passportFile = $form->get('file_passport')->getData();
            // dd($passportFile);

            if($passportFile){
                // add the file to the folder 'passport' & remove the old file & return the file name
                $passportFileName = $fileUploader->upload($passportFile, $candidate, 'passport', 'passport');
                // set property of candidate
                $candidate->setFilePassport($passportFileName);
            }

            $entityManager->persist($candidate);
            $entityManager->flush();

            $this->addFlash('success', 'Candidate updated successfully!');
        }

        return $this->render('candidate/index.html.twig', [
            'candidate' => $candidate,
            'form' => $form,
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
}
