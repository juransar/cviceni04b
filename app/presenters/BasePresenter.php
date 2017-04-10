<?php

namespace App\Presenters;

use Nette\Application\UI\Presenter;

/**
 * Class BasePresenter
 * @package App\Presenters
 */
abstract class BasePresenter extends Presenter
{
    public $basePath = __DIR__;

}
