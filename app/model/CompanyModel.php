<?php

namespace App\Model;

use Tracy\Debugger;


class CompanyModel extends BaseModel
{
    /**
     * Metoda vrací seznam všech firem seřazené podle jména
     */
    public function listCompanies()
    {
        return  $this->database->table('company')->order('name ASC')->fetchAll();
    }

    /**
     * Metoda vrací firmu se zadaným id, pokud neexistuje vrací NoDataFound.
     * @param int  $id
     */
    public function getCompany($id)
    {
        $res = $this->database->table('company')->where(['id' => $id])->fetch();
        if (!$res) throw new NoDataFound();
        return $res;
    }

    /**
     * Metoda vrací vloží novou firmu
     * @param array  $values
     * @return $id vložené firmy
     */
    public function insertCompany($values)
    {
        $row = $this->database->table('company')->insert([
              'name' => $values['name']
            , 'phone' => $values['phone']
            , 'registered' => 'now'
            , 'is_dph' => $values['is_dph']
            , 'tax_num' =>$values['taxNum']
        ]);
        return $row->id;
    }

    /**
     * Metoda edituje firmu, pokud neexistuje vrací NoDataFound.
     * @param array  $values
     */
    public function updateCompany($id, $values)
    {
        $this->getCompany($id);
        $row = $this->database->table('company')
            ->where(['id' => $id])
            ->update($values);
    }

    /**
     * Metoda odebere firmu, pokud neexistuje vrací NoDataFound.
     * @param array  $values
     */
    public function deleteCompany($id)
    {
        $this->getCompany($id);
        $row = $this->database->table('company')
            ->where(['id' => $id])
            ->delete();
    }
}