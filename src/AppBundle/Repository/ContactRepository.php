<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * BookRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ContactRepository extends EntityRepository
{

    public function searchContact($search)
    {
        return $this->getEntityManager()
            ->createQuery(
                'SELECT t.username , t.adress, t.phone_number, t.id
              FROM AppBundle:User t
              WHERE t.username LIKE :username'
            )->setParameters([
                'username' => '%' . $search . '%'
            ])->getResult();
    }
}
