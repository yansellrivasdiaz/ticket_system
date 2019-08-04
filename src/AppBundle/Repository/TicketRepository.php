<?php

namespace AppBundle\Repository;

/**
 * TicketRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class TicketRepository extends \Doctrine\ORM\EntityRepository
{
    public function getByDateRange($startdate,$enddate){
        if($startdate != null && $enddate != null){
            return $this->createQueryBuilder('t')
                ->where('t.createdAt >= :startdate AND t.createdAt <= :enddate')
                ->setParameters([
                    "startdate" => $startdate,
                    "enddate" => $enddate
                ])
                ->getQuery();
        }elseif($startdate == null && $enddate != null){
            return $this->createQueryBuilder('t')
                ->where('t.createdAt <= :enddate')
                ->setParameter("enddate" , $enddate)
                ->getQuery();
        }elseif($startdate != null && $enddate == null){
            return $this->createQueryBuilder('t')
                ->where(" t.createdAt like'%$startdate%' ")
                ->getQuery();
        }else{
            return $this->createQueryBuilder('t')
                ->select('t')
                ->getQuery();
        }
    }
}