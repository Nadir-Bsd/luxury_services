<?php

namespace App\Controller\Admin;

use App\Entity\Client;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class ClientCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Client::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [

            TextField::new('societyName'),
            TextField::new('activity'),
            TextField::new('notes'),
            AssociationField::new('user'),
            DateTimeField::new('createdAt')->hideOnForm(),
            DateTimeField::new('deletedAt')->hideOnForm(),
        ];
    }
}
