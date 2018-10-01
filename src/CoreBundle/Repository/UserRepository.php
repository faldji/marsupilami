<?php

namespace CoreBundle\Repository;

/**
 * UserRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class UserRepository extends \Doctrine\ORM\EntityRepository
{
    public function findfriends($_user_id): array
    {
        $querry = $this->createQueryBuilder('f')
            ->Where('f.id <> :id')
            ->setParameter('id',$_user_id)
            ->getQuery();
        return $querry->execute();
    }
}
