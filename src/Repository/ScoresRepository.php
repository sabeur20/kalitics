<?php

namespace App\Repository;

use App\Entity\Scores;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
/**
 * @method Scores|null find($id, $lockMode = null, $lockVersion = null)
 * @method Scores|null findOneBy(array $criteria, array $orderBy = null)
 * @method Scores[]    findAll()
 * @method Scores[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ScoresRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Scores::class);
    }

    /**
     * function check Score in Day
     * @param $users
     * @param $sites
     * @param $scoreDate
     * @return int
     */
    public function checkScoreDay($users, $sites, $scoreDate)
    {
        $query = $this->createQueryBuilder('s')
            ->where('s.users = :users')
            ->andWhere('s.sites = :sites')
            ->andWhere('s.scoreDate = :scoreDate')
            ->setParameter('users', $users)
            ->setParameter('sites', $sites)
            ->setParameter('scoreDate', $scoreDate)
            ->getQuery()
            ->getResult();
        return count($query);
    }

    /**
     * @param $users
     * @param $sites
     * @param $scoreDate
     * @return mixed
     */
    public function checkScoreLengthTime($users, $sites, $scoreDate)
    {
        $date = new \DateTime($scoreDate);
        $week = $date->format("W");
        $year = $date->format("Y");

        $query = $this->createQueryBuilder('s')
            ->select('SUM(s.lengthTime) as sumLengthTime')
            ->where('s.users = :users')
            ->andWhere('s.sites = :sites')
            ->andWhere('WEEK(s.scoreDate, 1 ) = :weekScoreDate')
            ->andWhere('YEAR(s.scoreDate) = :yearScoreDate')
            ->setParameter('users', $users)
            ->setParameter('sites', $sites)
            ->setParameter('weekScoreDate', $week)
            ->setParameter('yearScoreDate', $year)
            ->getQuery()
            ->getSingleScalarResult();
        return $query;
    }

    /**
     * @param $sites
     * @return int
     */
    public function scoreUsersSite( $sites ){
        $query = $this->createQueryBuilder('s')
            ->select('DISTINCT(s.users)')
            ->andWhere('s.sites = :sites')
            ->setParameter('sites', $sites)
            ->getQuery()
            ->getResult();
        return count($query);
    }

    /**
     * @param $sites
     * @return mixed
     */
    public function scoreSumLengthTimeSite( $sites)
    {
        $query = $this->createQueryBuilder('s')
            ->select('SUM(s.lengthTime) as sumLengthTime')
            ->where('s.sites = :sites')
            ->setParameter('sites', $sites)
            ->getQuery()
            ->getSingleScalarResult();
        return $query;
    }
}
