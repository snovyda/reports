<?php

namespace App\Services;


use App\Entity\Report;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Class ReportsService
 * @package App\Services
 */
class ReportsService
{
    /* var EntityManagerInterface */
    protected $em;

    /**
     * ReportsService constructor.
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @return mixed
     */
    public function getAllReports()
    {
        return $this->em->getRepository(Report::class)->getAll();
    }

    /**
     * @param UserInterface|null $user
     * @param array $attributes
     * @param string $fileName
     * @return Report|bool
     */
    public function saveReportData(?UserInterface $user, array $attributes = [], string $fileName = '')
    {
        if (empty($attributes) || !$fileName || empty($user)) {
            return false;
        }

        $report = new Report();
        if (array_key_exists('edrpou', $attributes)) {
            $report->setEdrpou($attributes['edrpou']);
        }
        if (array_key_exists('name', $attributes)) {
            $report->setName($attributes['name']);
        }
        if (array_key_exists('nreg', $attributes)) {
            $report->setNreg($attributes['nreg']);
        }
        if (array_key_exists('public_dt', $attributes)) {
            $report->setPublicDt($attributes['public_dt']);
        }
        $report->setFile($fileName);
        $report->setUser($user);

        $this->em->persist($report);
        $this->em->flush();

        return $report;
    }
}
