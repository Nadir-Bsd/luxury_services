<?php

namespace App\Controller;

use App\Entity\Candidate;
use App\Entity\User;
use App\Form\CandidateType;
use App\Interfaces\FileHandlerInterface;
use App\Interfaces\PasswordUpdaterInterface;
use App\Interfaces\ProfileProgressCalculatorInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/profile')]
final class CandidateController extends AbstractController
{
    #[Route('/', name: 'app_candidate_edit', methods: ['GET', 'POST'])]
    public function edit(
        Request $request, 
        EntityManagerInterface $entityManager, 
        FileHandlerInterface $fileHandler, 
        PasswordUpdaterInterface $passwordUpdater, 
        ProfileProgressCalculatorInterface $calculateProgress,
    ): Response
    {

        /** @var User */
        $user = $this->getUser();

        /** @var Candidate */
        $candidate = $user->getCandidate();

        // calculate the progress of the profile
        $n = $calculateProgress->calculateProgress($candidate);

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

            // get datas
            $email = $form->get('email')->getData();
            $newPassword = $form->get('newPassword')->getData();

            // check if the data for change the password
            if ($email && $newPassword) {
                // update the password with the new password and the email
                $passwordUpdater->updatePassword($candidate->getUser(), $email, $newPassword);
            } elseif ($email || $newPassword) {
                $this->addFlash('error', 'Please fill in both email and password fields');
            }

            // calculate the progress of the profile push it the result in dataBase

            $entityManager->persist($candidate);
            $entityManager->flush();

            $this->addFlash('success', 'Candidate updated successfully!');

            return $this->redirectToRoute('app_candidate_edit');
        }

        return $this->render('candidate/index.html.twig', [
            'candidate' => $candidate,
            'form' => $form,
            'n' => $n,
            'OriginalfilePassportName' => $this->getOriginalFilename($candidate->getFilePassport()),
            'OriginalfileCvName' => $this->getOriginalFilename($candidate->getFileCv()),
            'OriginalfilePpName' => $this->getOriginalFilename($candidate->getFilePp()),
        ]);
    }

    #[Route('/delete', name: 'app_candidate_delete', methods: ['GET', 'POST'])]
    public function delete(EntityManagerInterface $entityManager): Response
    {
        /** @var User */
        $user = $this->getUser();

        /** @var Candidate */
        $candidate = $user->getCandidate();

        // add immutable file to delete for the candidate 
        $candidate->setDeletedAt();

        // set user role has DELETED
        $user->setRoles(['DELETED']);

        // to say that entity has been modified and will be updated in the database
        $entityManager->persist($candidate);
        $entityManager->persist($user);

        $entityManager->flush();

        $this->addFlash('success', 'Candidate deleted successfully!');
        return $this->redirectToRoute('app_logout');
    }

    private function getOriginalFilename(?string $filename): ?string
    {
        return $filename ? preg_replace('/-\w{13}(?=\.\w{3,4}$)/', '', $filename) : null;
    }
}
