<?php

namespace App\Forms;

use Services\MyValidators;
use Exception;
use Nette\Application\UI\Form;
use Nette\Forms\Container;
use App\Model\PidModel;
use Nette\Utils\ArrayHash;
use Tracy\Debugger;
use Nette\Forms\Controls\TextInput;
use Nette\Utils\Json;
use Nette\Utils\Strings;
use Nette\Object;

/**
 * Továrnička na tvorbu formulářů pro správu rc.
 *
 * @author     Jiří Chludil
 * @author     Jindřich Máca
 * @copyright  Copyright (c) 2017 Jiří Chludil
 * @package    App\Forms
 */
class PidFormFactory extends Object
{
    /** @var PidModel Model pro urc. */
    private $pidModel;

    /**
     * Setter pro formulářovou továrničku a modely
     * @param PidModel $pidModel automatiky injetovaný model
     */
    public function injectDependencies( PidModel $pidModel ) {
        $this->pidModel = $pidModel;
    }



    /** @inheritdoc */
    protected function addCommonFields(Container &$form, $args = null)
    {
        $form->addText('name', 'Rodné číslo')
            ->setAttribute('placeholder', 'Vyplň rodné číslo');
    }


    /**
     * Vytváří komponentu formuláře pro přidávání nového rc.
     * @param null|array $args další argumenty
     * @return Form formulář pro přidávání nového rc
     */
    public function createAddForm($args = null)
    {
        $form = new Form(NULL, 'addForm');
        $form->addProtection('Ochrana');
        $this->addCommonFields($form);
        $form->addSubmit('send', 'Přidej');
        $form->onValidate[] = [$this, 'validatePidForm'];
        $form->onSuccess[] = [$this, "newFormSucceeded"];
        return $form;
    }

    /**
     * Vytváří komponentu formuláře pro editaci rc.
     * @param null|array $args další argumenty
     * @return Form formulář pro editaci rc
     */
    public function createEditForm($args = null)
    {
        $form = new Form(NULL, 'editForm');
        $form->addProtection('Ochrana');
        $this->addCommonFields($form);
        $form->addSubmit('send', 'Aktualizuj');
        $form->addHidden('id');
        $form->onValidate[] = [$this, 'validatePidForm'];
        $form->onSuccess[] = [$this, "editFormSucceeded"];
        return $form;
    }

    /**
     * Vytváří komponentu formuláře pro smazání rc.
     * @param null|array $args další argumenty
     * @return Form formulář pro smazání rc
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
     * Zpracování validních dat z formuláře a následného přidání rc.
     * @param Form      $form   formulář
     * @param ArrayHash $values data
     */
    public function newFormSucceeded(Form $form, ArrayHash $values)
    {
        try {
            $this->pidModel->insertPid($values);
        } catch (Exception $exception) {
            $form->addError($exception);
        }
    }
    public function validatePidForm(Form $form, ArrayHash $values){
        try {
            $months30=array(4,6,9,11);
            $months31=array(1,3,5,7,8,10,12);
            $name=$values->name;
            $y=substr($name,0,2);
            if(strlen($name)!=10 || !is_numeric($name) || fmod($name, 11)!=0
        ){
                $form['name']->addError('Incorrect RC value');
            }
            $m=substr($name,2,2);
            if(!((1<=$m && $m<=12) ||(51<=$m && $m<=62))){
                $form['name']->addError('Incorrect RC value (month doesn\'t match');
            }
            if($m[0]>=5) $m=$m-50;
            $d=substr($name,4,2);
            if(in_array($m,$months30) && !((1<=$d) && ($d<=30))){
                $form['name']->addError('Incorrect RC value (day doesn\'t match');
            }
            else if(in_array($m,$months31) && !((1<=$d) && ($d<=31))){
                $form['name']->addError('Incorrect RC value (day doesn\'t match');
            }
            else if ($m==2 && !((1<=$d) && !((1<=$d) && ($d<=28)))){
                $form['name']->addError('Incorrect RC value (day doesn\'t match');
            }
        }
        catch (Exception $exception) {
            $form->addError($exception);
        }
        //01-12 51-62
    }
    public function is_leap_year($year)
{
    return ((($year % 4) == 0) && ((($year % 100) != 0) || (($year %400) == 0)));
}
    /**
     * Zpracování validních dat z formuláře a následné aktualizace rc.
     * @param Form      $form   formulář
     * @param ArrayHash $values data
     */
    public function editFormSucceeded(Form $form, ArrayHash $values)
    {
        try {
            $id = $values['id'];
            unset($values['id']);
            $this->pidModel->updatePid($id, $values);
        } catch (Exception $exception) {
            Debugger::log($e);
            $form->addError($exception);
        }
    }

    /**
     * Zpracování validních dat z formuláře a následného odebrání rc.
     * @param Form      $form   formulář
     * @param ArrayHash $values data
     */
    public function deleteFormSucceeded(Form $form, ArrayHash $values)
    {
        try {
            $this->pidModel->deletePid($values['id']);
        } catch (Exception $exception) {
            $form->addError($exception);
        }
    }
}
