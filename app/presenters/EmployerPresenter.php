<?php

namespace App\Presenters;

use App\Model\EmployerModel;
use App\Model\CompanyModel;
use App\Forms\EmployerFormFactory;
use App\Model\UtilityModel;
use App\Model\PidModel;
use Nette\Application\UI\Form;
use App\Model\NoDataFound;
use Tracy\Debugger;



class EmployerPresenter extends BasePresenter
{
    /** @var EmployerFormFactory - Formulářová továrnička pro správu zaměstanců */
    private $formFactory;

    /** @var EmployerModel - model pro management zaměstanců */
    private $employerModel;

    /** @var CompanyModel - model pro management firem */
    private $companyModel;

    /** @var UtilityModel - model pro management rc*/
    private $utilityModel;

    /** @var PidModel - model pro management rc*/
    private $pidModel;

    /**
     * Setter pro formulářovou továrničku a modely správy uživatelů
     * @param EmployerFormFactory $formFactory automaticky injectovaná formulářová továrnička
     * @param EmployerModel $employerModel automatiky injetovaný model
     * @param CompanyModel $companyModel automatiky injetovaný model pro správu uživatelů
     * @param UtilityModel $utilityModel automatiky injetovaný model
     * @param PidModel $pidModel automatiky injetovaný model
     */
    public function injectDependencies(
        EmployerFormFactory $formFactory,
        EmployerModel $employerModel,
        CompanyModel $companyModel,
        UtilityModel $utilityModel,
        PidModel $pidModel
    )
    {
        $this->formFactory = $formFactory;
        $this->employerModel = $employerModel;
        $this->companyModel = $companyModel;
        $this->utilityModel = $utilityModel;
        $this->pidModel = $pidModel;
    }

    /**
     * Akce pro vkádání
     */
    public function actionAdd() {
        $form = $this['addForm'];
        try {
            $companies = $this->companyModel->listCompanies();
            $c = [];
            foreach($companies as $company)
                $c[$company['id']] = $company['name'];
            $form['company_id']->setItems($c);

            $pids = $this->pidModel->listPids();
            $p = [0 => '==========='];
            foreach($pids as $pid)
                $p[$pid['id']] = $pid['name'];
            $form['pid_id']->setItems($p);

        } catch (NoDataFound $e) {
            $form->addError('Nelze načíst data');
        }
    }

    /**
     * Akce pro editaci
     * @param int $id id zaměstnance
     */
    public function actionEdit($id) {
        $form = $this['editForm'];
        try {
            $companies = $this->companyModel->listCompanies();
            $c = [];
            foreach($companies as $company)
                $c[$company['id']] = $company['name'];
            $form['company_id']->setItems($c);

            $pids = $this->pidModel->listPids();
            $p = [0 => '==========='];
            foreach($pids as $pid)
                $p[$pid['id']] = $pid['name'];
            $form['pid_id']->setItems($p);

            $employer = $this->employerModel->getEmployer($id);
            $form->setDefaults($employer);
        } catch (NoDataFound $e) {
            $form->addError('Nelze načíst data');
        }
    }

    /**
     * Akce pro mazání
     * @param int $id id zaměstnance
     */
    public function actionDelete($id) {
        $form = $this['deleteForm'];
        $form['id']->setDefaultValue($id);
    }

    /**
     * Metoda pro vytvoření formuláře pro vložení
     * @return Form - formulář
     */
    public function createComponentAddForm()
    {
        $form = $this->formFactory->createAddForm();
        $form->onSuccess[] = function (Form $form) {
            $this->redirect('Employer:default');
        };
        return $form;
    }

    /**
     * Metoda pro vytvoření formuáře pro editaci
     * @return Form - formulář
     */
    public function createComponentEditForm()
    {
        $form = $this->formFactory->createEditForm();
        $form->onSuccess[] = function (Form $form) {
            $this->redirect('Employer:default');
        };
        return $form;
    }

    /**
     * Metoda pro vytvoření formuláře pro mazání
     * @return Form - formulář
     */
    public function createComponentDeleteForm()
    {
        $form = $this->formFactory->createDeleteForm();
        $form->onSuccess[] = function (Form $form) {
            $this->redirect('Employer:default');
        };
        return $form;
    }

    /**
     * Metoda pro naplnění dat pro šablonu dané akce
     */
    public function renderEdit($id) {
        $employer = $this->employerModel->getEmployer($id);
        $this->template->name = $employer['firstname'] . ' ' . $employer['surname'];
    }

    /**
     * Metoda pro naplnění dat pro šablonu dané akce
     */
    public function renderDelete($id) {
        $employer = $this->employerModel->getEmployer($id);
        $this->template->name = $employer['firstname'] . ' ' . $employer['surname'];
    }

    /**
     * Metoda pro naplnění dat pro šablonu dané akce
     */
    public function renderDefault() {
       $this->template->employers = $this->employerModel->listEmployers();
       $this->template->utility = $this->utilityModel;
    }
    public function renderAdd(){
        $form = $this['addForm'];
        $renderer = $form->getRenderer();
        $renderer->wrappers['controls']['container'] = 'dl';
        $renderer->wrappers['pair']['container'] = NULL;
        $renderer->wrappers['label']['container'] = 'dt';
        $renderer->wrappers['control']['container'] = 'dd';
    }
}
