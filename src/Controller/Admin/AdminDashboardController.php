<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Entity\Media;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminDashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        $routeBuilder = $this->get(AdminUrlGenerator::class);

        return $this->redirect(
            $routeBuilder
                ->setController(UserCrudController::class)
                ->generateUrl()
        );
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Anikura Server');
    }

    public function configureMenuItems(): iterable
    {
        return [ 
            MenuItem::linkToDashboard('Dashboard', 'fa fa-home'),
            
            MenuItem::linkToCrud('Users', 'fa fa-user', User::class),

            MenuItem::linkToCrud('Media', 'fa fa-film', Media::class),
        ];
    }
}
