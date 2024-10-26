<?php

namespace App\Repository;

use App\Entity\Student;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Student>
 */
class StudentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Student::class);
    }

//    /**
//     * @return Student[] Returns an array of Student objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('s.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Student
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }

        public function fetchStudentsByName($name){
            $mr=$this->getEntityManager();
            $req=$mr->createQuery("select s from App\Entity\Student s 
            where s.nom=:n");
            $req->setParameter('n',$name);
            $result=  $req->getResult();
            return $result;
        }
        public function fetchStudentByAge(){
            $mr=$this->getEntityManager();
            $req=$mr->createQuery('select s.nom from App\Entity\Student s
             where s.age>25');
            $result=  $req->getResult();
            return $result;
        }
        
        public function join (){
            $mr=$this->getEntityManager();
            $req=$mr->createQuery("select s.nom, c.name
             from App\Entity\Student s join s.classroom c 
             where c.name='3A40'");
            $result=  $req->getResult();
            return $result;
        }



        public function DQL(){
            $mr=$this->getEntityManager();
            $req=$this->createQuery('select s.nom from App\Entity\Student s');
            $result=  $req->getResult();
            return $result;
        }


        public function QB(){
            $req=$this->createQueryBuilder('s')
            ->select('s.nom')
            ->addSelect('c.name')
            ->join('s.classroom','c')
            ->where("c.name='3A40'")
            ->orderBy('s.nom','DESC');
            $preResult=$req->getQuery();
            $result=$preResult->getResult();
            return $result;
        }

}
