<?php

namespace App\Controller\Admin;

use App\Entity\Category;
use App\Entity\Contract;
use App\Entity\Job;
use EasyCorp\Bundle\EasyAdminBundle\Attribute\AdminDashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[AdminDashboard(routePath: '/admin', routeName: 'admin')]
class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        
        return $this->render('admin/my-dashboard.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Luxury Services');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');

        // if $this->getUser get roles and print only things that are allowed
        $user = $this->getUser();

        // ajoute un lien vers un CRUD des jobs
        yield MenuItem::linkToCrud('The Jobs Offer', 'fas fa-briefcase',  Job::class);
        yield MenuItem::linkToCrud('Contract Type', 'fas fa-file-signature',  Contract::class);
        yield MenuItem::linkToCrud('Category', 'fas fa-list',  Category::class);
    }
}
