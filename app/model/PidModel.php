<?php

namespace App\Model;

use Tracy\Debugger;


class PidModel extends BaseModel
{

    /** @var PidModel - model pro management rc*/
    private $pidModel;
    /**
     * Metoda vrací seznam všech rodných čísel
     */

    public function injectModels(
        PidModel $pidModel
    )
    {
        $this->pidModel = $pidModel;
    }


    /**
     * Metoda vrací seznam všech rodných čísel
     */
    public function listPids()
    {
        return  $this->database->table('pid')->order('name ASC')->fetchAll();
    }

    /**
     * Metoda vrací rodné číslo se zadaným id, pokud neexistuje vrací NoDataFound.
     * @param int  $id
     */
    public function getPid($id)
    {
        $res = $this->database->table('pid')->where(['id' => $id])->fetch();
        if (!$res) throw new NoDataFound();
        return $res;
    }

    /**
     * Metoda vrací rodné číslo se zadaným čílem, pokud neexistuje vrací NoDataFound.
     * @param int  $id
     */
    public function getPidByName($name)
    {
        $res = $this->database->table('pid')->where(['name' => $name])->fetch();
        if (!$res) return false;
        return $res;
    }

    /**
     * Metoda vrací vloží nové rodné číslo
     * @param array  $values
     * @return $id vloženého rodného čísla
     */
    public function insertPid($values)
    {
        $row = $this->database->table('pid')->insert([
            'name' => $values['name']
        ]);
        return $row->id;
    }

    /**
     * Metoda edituje rodné číslo, pokud neexistuje vrací NoDataFound.
     * @param array  $values
     */
    public function updatePid($id, $values)
    {
        $this->getPid($id);
        $row = $this->database->table('pid')
            ->where(['id' => $id])
            ->update($values);
    }

    /**
     * Metoda odebere rodné číslo, pokud neexistuje vrací NoDataFound.
     * @param array  $values
     */
    public function deletePid($id)
    {
        $this->getPid($id);
        $row = $this->database->table('pid')
            ->where(['id' => $id])
            ->delete();
    }
}