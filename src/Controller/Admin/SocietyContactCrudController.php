<?php

namespace App\Controller\Admin;

use App\Entity\SocietyContact;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class SocietyContactCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return SocietyContact::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('name'),
            TextField::new('phone'),
            TextField::new('email'),
            TextField::new('workstation'),
            AssociationField::new('client'),
        ];
    }
}
