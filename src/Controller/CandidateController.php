<?php

namespace App\Controller;

use App\Entity\Candidate;
use App\Entity\User;
use App\Form\CandidateType;
use App\Form\ChangePasswordType;
use App\Interfaces\FileHandlerInterface;
use App\Interfaces\PasswordUpdaterInterface;
use App\Repository\CandidateRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/profile')]
final class CandidateController extends AbstractController
{
    #[Route('/', name: 'app_candidate_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request ,EntityManagerInterface $entityManager, FileHandlerInterface $fileHandler, PasswordUpdaterInterface $passwordUpdater): Response
    {

        /** @var User */
        $user = $this->getUser();

        $candidate = $user->getCandidate();

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
            
            // get data
            $email = $form->get('email')->getData();
            $newPassword = $form->get('newPassword')->getData();

            // check the data
            if ($email && $newPassword) 
            {
                $passwordUpdater->updatePassword($candidate->getUser(), $email, $newPassword);
            } elseif ($email || $newPassword) {
                $this->addFlash('error', 'Please fill in both email and password fields');
            }

            $entityManager->persist($candidate);
            $entityManager->flush();

            $this->addFlash('success', 'Candidate updated successfully!');

            return $this->redirectToRoute('app_candidate_edit');
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
