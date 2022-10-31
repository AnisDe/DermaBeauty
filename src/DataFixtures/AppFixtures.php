<?php

namespace App\DataFixtures;

use App\Entity\Forum;
use App\Entity\Reply;
use App\Entity\ReplyLike;
use App\Entity\Sujet;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


class AppFixtures extends Fixture
{
    private $encoder;
    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');
        $users = [];
        for ($j=0;$j<10;$j++) {
            $user = new User();
            $user->setCin($j+10000);
            $user->setAdresse($faker->address);
            $user->setNumero($j);
            $user->setPrenom($faker->name);

            $user->setNom($faker->name);
            $user->setEmail($faker->name . "" . $j . "" . "@symfony.com");
            $user->setPassword($this->encoder->encodePassword($user,'123456789'));
            $user->setRoles(["ROLE_USER"]);
           // $user->setEmail($faker->name . "" . $j . "" . "@symfony.com");
            $manager->persist($user);
            $users[] = $user;
        }
        for ($i=0;$i<10;$i++){
            $sujet = new Sujet();
            $sujet->setNom($faker->name);
            $manager->persist($sujet);
            for ($j=0;$j<5;$j++){




                $forum = new Forum();
                $forum->setUser($faker->randomElement($users));
                $forum->setBlog($faker->paragraph(2));
                $forum->setTitre($faker->sentence);
                $forum->setCreationDate($faker->dateTimeBetween('-6 months','-3 months'));
                $forum->setSujet($sujet);
                $manager->persist($forum);

                for ($k=1;$k<mt_rand(1,5);$k++){
                    $reply = new Reply();

                    $reply->setUser($faker->randomElement($users));

                    $reply->setContent($faker->paragraph(2));
                    $reply->setForum($forum);

                    $reply->setCreationDate($faker->dateTimeBetween('-2 months'));
                    $manager->persist($reply);
                    for ($n = 0;$n < mt_rand(0,10);$n++){
                        $like = new ReplyLike();
                        $like->setReply($reply);
                        $like->setUser($faker->randomElement($users));
                        $manager->persist($like);

                    }
                }

            }



        }





        $manager->flush();
    }
}
