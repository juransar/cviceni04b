<?php

namespace App\Forms;

use App\Model\EmployerModel;
use Exception;
use Nette\Application\UI\Form;
use Nette\Forms\Container;
use Nette\Forms\Controls\TextInput;
use Nette\Object;
use Nette\Utils\ArrayHash;
use Nette\Utils\Strings;
use Tracy\Debugger;


/**
 * Továrnička na tvorbu formulářů pro správu zaměstnanců.
 *
 * @author     Jiří Chludil
 * @author     Jindřich Máca
 * @copyright  Copyright (c) 2017 Jiří Chludil
 * @package    App\Forms
 */
class EmployerFormFactory extends Object
{
    /** @var EmployerModel Model pro správu zaměstnanců. */
    private $employerModel;

    public function injectDependencies( EmployerModel $employerModel ) {
        $this->employerModel = $employerModel;
    }


    /** @inheritdoc */
    protected function addCommonFields(Container &$form, $args = null)
    {
        $form->addSelect('company_id','Firma')
            ->setAttribute('placeholder', '============')
            ->setRequired('Je třeba vybrat firmu');
        $form->addText('surname', 'Příjmení')
            ->setAttribute('placeholder', 'Vyplň příjmení')
            ->setRequired('Je třeba vyplnit jméno');
        $form->addText('firstname', 'Jméno')
            ->setAttribute('placeholder', 'Vyplń jméno')
            ->setRequired('Je třeba vyplnit jméno');
        $form->addText('salary', 'Plat')
            ->setType('number')
            ->setAttribute('placeholder', 'Vyplň plat')
            ->setRequired('Je třeba vyplnit plat')
            ->addRule(Form::RANGE, 'Plat musi byt od 100 do 100000', [100, 100000]);

        $form->addSelect('pid_id','Rodné číslo')
            ->setAttribute('placeholder', '============');
    }


    /**
     * Vytváří komponentu formuláře pro přidávání nového zaměstance.
     * @param null|array $args další argumenty
     * @return Form formulář pro přidávání nového zaměstnance
     */
    public function createAddForm($args = null)
    {
        $form = new Form(NULL, 'addForm');
        $form->addProtection('Ochrana');
        $this->addCommonFields($form);
        $form->addSubmit('send', 'Přidej');
        $form->onValidate[] = [$this, 'validateEmployerForm'];
        $form->onSuccess[] = [$this, "newFormSucceeded"];
        return $form;
    }

    /**
     * Vytváří komponentu formuláře pro editaci zaměstnance.
     * @param null|array $args další argumenty
     * @return Form formulář pro editaci zaměstnance
     */
    public function createEditForm($args = null)
    {
        $form = new Form(NULL, 'editForm');
        $form->addProtection('Ochrana');
        $this->addCommonFields($form);
        $form->addSubmit('send', 'Aktualizuj');
        $form->addHidden('id');
        $form->onSuccess[] = [$this, "editFormSucceeded"];
        return $form;
    }

    /**
     * Vytváří komponentu formuláře pro smazání zaměstnance.
     * @param null|array $args další argumenty
     * @return Form formulář pro smazání zaměstnance
     */
    public function createDeleteForm($args = null)
    {
        $form = new Form(NULL, 'deleteForm');
        $form->addProtection('Ochrana');
        $form->addSubmit('send', 'Odeber');
        $form->addHidden('id');
        $form->onSuccess[] = [$this, "deleteFormSucceeded"];
        return $form;
    }

    /**
     * Zpracování validních dat z formuláře a následného přidání zaměstnance.
     * @param Form      $form   formulář
     * @param ArrayHash $values data
     */
    public function newFormSucceeded(Form $form, ArrayHash $values)
    {
        try {
            $this->employerModel->insertEmployer($values);
        } catch (Exception $exception) {
            $form->addError($exception);
        }
    }
    public function validateEmployerForm(Form $form, ArrayHash $values){
        try {
            $surname=$values->surname;
            $firstname=$values->firstname;
            if(!ctype_alpha($surname) ||  !ctype_upper ( $surname[0])){
                $form['surname']->addError('Surname contains something other than letter or its first letter is not uupercase');
            }
            if(!ctype_alpha($firstname) || ! ctype_upper ( $firstname[0])){
                $form['firstname']->addError('Firstname contains something other than letter or its first letter is not uupercase');
            }
        }
        catch (Exception $exception) {
            $form->addError($exception);
        }
    }
    /**
     * Zpracování validních dat z formuláře a následné aktualizace zaměstnance.
     * @param Form      $form   formulář
     * @param ArrayHash $values data
     */
    public function editFormSucceeded(Form $form, ArrayHash $values)
    {
        try {
            $id = $values['id'];
            unset($values['id']);
            $this->employerModel->updateEmployer($id, $values);
        } catch (Exception $exception) {
            Debugger::log($exception);
            $form->addError($exception);
        }
    }

    /**
     * Zpracování validních dat z formuláře a následného odebrání zaměstnance.
     * @param Form      $form   formulář
     * @param ArrayHash $values data
     */
    public function deleteFormSucceeded(Form $form, ArrayHash $values)
    {
        try {
            $this->employerModel->deleteEmployer($values['id']);
        } catch (Exception $exception) {
            $form->addError($exception);
        }
    }
}
