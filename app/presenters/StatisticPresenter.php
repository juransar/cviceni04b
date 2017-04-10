<?php

namespace App\Presenters;

use App\Model\StatisticModel;
use Tracy\Debugger;



class StatisticPresenter extends BasePresenter
{

    /** @var StatisticModel - model pro statistiky */
    private $statisticModel;

    /**
     * Setter pro model statistiky
     * @param StatisticModel $statisticModel automatiky injetovaný model pro správu statistik
     */
    public function injectDependencies(
        StatisticModel $statisticModel
    )
    {
        $this->statisticModel = $statisticModel;
    }

    /**
     * Metoda pro naplnění dat pro šablonu dané akce
     */
    public function renderDefault() {
       $this->template->statistics = $this->statisticModel->listStatistic();
    }
}
