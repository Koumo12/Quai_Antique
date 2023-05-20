# Quai_Antique

is a [Symfony](https://symfony.com/doc/current/index.html) project bootstrapped with **'composer create-project symfony/skeleton:"5.4.*" QuaiAntique'**.


## Getting Started
First, if you need to get our project code, install the dependencies with Composer. 
Setup the project with the following commands:

```bash
# clone the project to download its contents
cd my-project/
git clone ...

# make Composer install the project´s dependencies into vendor/
cd my-project/
composer install

```

Second, run the development server:
```bash
php -S localhost:8000 -t public/
```

Open [http://localhost:8000](http://localhost:8000) with your browser to see the result.

The project is composed of two parts:

**Frontend:** 
The Application give the users the possibility to visit our different dishes and can reserve a table. The visitor can create an account, if he wants.

**Backend:**
As administrator, you can get access to the backend of the application from the same login page for the visitor with an account. 
To create your first account as admin, use DataFixtures to save your account data in the database. 

```bash
# install Fixtures 
composer req orm-fixtures --dev
```
```bash
# Create your account
<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\PasswordHasherFactoryInterface;

class AppFixtures extends Fixture
{
    public function __construct( private PasswordHasherFactoryInterface $passwordHasherFactory)
    {
        
    }
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);

        $admin = new User();
        $admin->setEmail('admin@gmail.com');
        $admin->setRoles(['ROLE_ADMIN']);
        $admin->setPassword($this->passwordHasherFactory->getPasswordHasher(User::class)->hash('LTdyRrn8r&@u4345'));
        $manager->persist($admin);

        $manager->flush();
    }
}
```
```bash
# Load the fixtures in the database:
php bin/console doctrine:fixtures:load 
```
that was created for the Admin. With this account, you can add, edit and delete the data on the apps and create other admin accounts for your employees. 

Enjoy :smiley: !!!
