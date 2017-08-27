<?php

namespace HelpMeAbstract\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\NoResultException;
use HelpMeAbstract\Entity\Revision;

class RevisionRepository extends EntityRepository
{
    /**
     * @param $proposalId
     * @return Revision|null
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function findLatestForProposal($proposalId)
    {
        try{
            return $this->createQueryBuilder('p')
                ->where('p.proposalId = ?1')
                ->orderBy('p.createdDate', 'DESC')
                ->setMaxResults(1)
                ->setParameter(1, $proposalId)
                ->getQuery()
                ->getSingleResult();
        } catch (NoResultException $e){
            return null;
        }
    }
}
