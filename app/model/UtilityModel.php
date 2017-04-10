<?php

namespace App\Model;

class UtilityModel extends BaseModel
{
    /** @var PidModel - model pro management rc*/
    private $pidModel;

    public $months = array(
        1 => 31,
        2 => 29,
        3 => 31,
        4 => 30,
        5 => 31,
        6 => 30,
        7 => 31,
        8 => 31,
        9 => 30,
        10 => 31,
        11 => 30,
        12 => 31
    );

    public function __construct(PidModel $pidModel) {
        $this->pidModel = $pidModel;
    }

    /**
     * Metoda detekuje pohlaví -1 = nedefinováno, 0 - žena, 1 - muž
     * @param int  $id rodného čísla
     */
    public function isMan($id)
    {
        if(!$id) return -1;
        $pid = $this->pidModel->getPid($id);
        if(!$pid) return -1;
        $rc = substr($pid['name'],2,2);
        return $rc<50;
    }

    public function isCorrectPid($pid) {
        // kontrola 10 čísel
        if (strlen($pid) != 10) return false;
        // kontrola dělitelnosti 11 s kontrolním posledním číslem
        $checknum = fmod($pid, 11);
        // vyjímka při 10
        if ($checknum == 10) $checknum = 0;
        $num = substr($pid,-1);
        if((int)$checknum != (int)$num) return false;

        return true;
    }

    /**
     * Metoda detekuje datum narození -1 = nedefinováno, d.m.y
     * @param int  $id rodného čísla
     */
    public function getBirthDay($id)
    {
        if(!$id) return -1;
        $pid = $this->pidModel->getPid($id);
        if(!$pid) return -1;

        if(!$this->isCorrectPid($pid['name'])) return -1;

        // vyjmutí datumu
        $r = substr($pid['name'],0,2);
        // podmínka pro určení století
        if ($r >= 54) {$r = '19' . $r;} else {$r = '20' . $r;}

        $m = substr($pid['name'],2,2);
        if ((int)$m > 50) { $m = '0' . ((int)$m - 50); }
        $d = substr($pid['name'],4,2);

        // kontrola platnosti data (nemůže se narodit v budoucnu)
        if ((int)$r > (int)date("Y")) return -1;
        if ((int)$r == (int)date("Y")){
            if ((int)$m > (int)date("m")) return - 1;
            if ((int)$m == (int)date("m")) {
                if ((int)$d > (int)date("d")) return - 1;
            }
        }

        // kontrola správnosti dnů v měsíci
        if($this->months[(int)$m] < (int)$d) return -1;
        // kontrola přestupného roku
        if((int)$m == 2) {
            if(fmod($r, 4) != 0 ) {
                if ((int)$d >= 29) return -1;
            }
        }

        // složení datumu
        $date = $d . '.' . $m . '.' . $r;

        return $date;
    }

    public function filterPhone ($number) {
        if (strlen($number) != 9) return false;
        return '+420 ' . number_format($number, 0, '', ' ');
    }

}