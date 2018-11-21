<?php

/*
 * This file is part of the Symfony package.
 * (c) Stéphane BRIERE <stephanebriere@gdpweb.fr>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Repository;

class TrickRepository extends \Doctrine\ORM\EntityRepository
{
    public function getAll()
    {
        $query = $this->createQueryBuilder('a')
            ->getQuery();

        return $query->getResult();
    }

    public function getListTricks($limit)
    {
        $query = $this->createQueryBuilder('a')
            ->setMaxResults($limit)
            ->getQuery();

        return $query->getResult();
    }

    /**
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function countTricksMax()
    {
        return $this->createQueryBuilder('a')
            ->select('COUNT(a)')
            ->getQuery()
            ->getSingleScalarResult();
    }
}
