<?php

namespace App\Model;

use App\Model\EmployerModel;
use App\Model\CompanyModel;
use Tracy\Debugger;


class StatisticModel extends BaseModel
{

    /** @var CompanyModel - model pro management firem */
    private $companyModel;

    /** @var EmployerModel - model pro management zaměstanců */
    private $employerModel;

    public function __construct(CompanyModel $companyModel, EmployerModel $employerModel) {
        $this->companyModel = $companyModel;
        $this->employerModel = $employerModel;
    }

    /**
     * Metoda vrací seznam všech statistik firem, záznam bude mít položky název firmz, minální plat ve firmě, maximální plat ve firmě, průměrný plat a součet všech platů.
     */
    public function listStatistic()
    {
        /** TODO */
        //return  $this->database->table('employer')->order('surname ASC')->fetchAll();

        $companies = $this->companyModel->listCompanies();
        $statistic = array();
        foreach($companies as $c) {
            $employees = $this->employerModel->getEmployeesByCompanyWithSum($c->id);
            if ($employees->count("id") == 0) {$statistic[] = array(
                'name' => $c->name,
                'min' => 0,
                'max' => 0,
                'avg' => 0,
                'sum' => 0
            );
            } else {
                $min = $employees->min("salary");
                $max = $employees->max("salary");
                $sum = $employees->sum("salary");
                $avg = $sum / $employees->count("id");

                $statistic[] = array(
                    'name' => $c->name,
                    'min' => $min,
                    'max' => $max,
                    'avg' => $avg,
                    'sum' => $sum
                );
            }
        }

        return $statistic;
    }
  }