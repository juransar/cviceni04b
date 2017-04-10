<?php

namespace App\Presenters;

use App\Model\CompanyModel;
use App\Model\UtilityModel;
use App\Forms\CompanyFormFactory;
use Nette\Application\UI\Form;
use App\Model\NoDataFound;
use Tracy\Debugger;



class CompanyPresenter extends BasePresenter
{
    /** @var CompanyFormFactory - Formulářová továrnička pro správu firem */
    private $formFactory;

    /** @var CompanyModel - model pro management firem */
    private $companyModel;

    /** @var UtilityModel - model pro management rc*/
    private $utilityModel;


    /**
     * Setter pro formulářovou továrničku a modely
     * @param CompanyFormFactory $formFactory automaticky injectovaná formulářová továrnička
     * @param CompanyModel $companyModel automatiky injetovaný model
     */
    public function injectDependencies(
        CompanyFormFactory $formFactory,
        CompanyModel $companyModel,
        UtilityModel $utilityModel
    )
    {
        $this->formFactory = $formFactory;
        $this->companyModel = $companyModel;
        $this->utilityModel = $utilityModel;
    }

    /**
     * Akce pro editaci
     * @param int $id id firmy
     */
    public function actionEdit($id) {
        $form = $this['editForm'];
        try {
            $company = $this->companyModel->getCompany($id);
            Debugger::log($company['id']);
            $form->setDefaults($company);
        } catch (NoDataFound $e) {
            Debugger::log($e);
            $form->addError('Nelze načíst data');
        }
    }

    /**
     * Akce pro mazání
     * @param int $id id firmy
     */
    public function actionDelete($id) {
        $form = $this['deleteForm'];
        $form['id']->setDefaultValue($id);
    }

    /**
     * Metoda pro vytvoření formuáře pro vložení
     * @return Form - formulář
     */
    public function createComponentAddForm()
    {
        $form = $this->formFactory->createAddForm();
        $form->onSuccess[] = function (Form $form) {
            $this->redirect('Company:default');
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
            $this->redirect('Company:default');
        };
        return $form;
    }

    /**
     * Metoda pro vytvoření formuáře pro mazání
     * @return Form - formulář
     */
    public function createComponentDeleteForm()
    {
        $form = $this->formFactory->createDeleteForm();
        $form->onSuccess[] = function (Form $form) {
            $this->redirect('Company:default');
        };
        return $form;
    }


    /**
     * Metoda pro naplnění dat pro šablonu dané akce
     */
    public function renderEdit($id) {
        $company = $this->companyModel->getCompany($id);
        $this->template->name = $company['name'];
        $form = $this['editForm'];
        $renderer = $form->getRenderer();
        $renderer->wrappers['controls']['container'] = 'dl';
        $renderer->wrappers['pair']['container'] = NULL;
        $renderer->wrappers['label']['container'] = 'dt';
        $renderer->wrappers['control']['container'] = 'dd';

    }

    /**
     * Metoda pro naplnění dat pro šablonu dané akce
     */
    public function renderDelete($id) {
        $company = $this->companyModel->getCompany($id);
        $this->template->name = $company['name'];
    }

    /**
     * Metoda pro naplnění dat pro šablonu dané akce
     */
    public function renderDefault() {
       $this->template->companies = $this->companyModel->listCompanies();
       $this->template->utility = $this->utilityModel;
    }
}