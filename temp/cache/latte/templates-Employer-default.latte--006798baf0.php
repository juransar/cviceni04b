<?php
// source: C:\xampp\htdocs\cviceni04b\app\presenters/templates/Employer/default.latte

use Latte\Runtime as LR;

class Template006798baf0 extends Latte\Runtime\Template
{
	public $blocks = [
		'content' => 'blockContent',
	];

	public $blockTypes = [
		'content' => 'html',
	];


	function main()
	{
		extract($this->params);
		if ($this->getParentName()) return get_defined_vars();
		$this->renderBlock('content', get_defined_vars());
		return get_defined_vars();
	}


	function prepare()
	{
		extract($this->params);
		if (isset($this->params['e'])) trigger_error('Variable $e overwritten in foreach on line 31');
		Nette\Bridges\ApplicationLatte\UIRuntime::initialize($this, $this->parentName, $this->blocks);
		
	}


	function blockContent($_args)
	{
		extract($_args);
?>

<h1>Zaměstnanci</h1>
<hr>
<ul class="nav nav-pills">
    <li role="presentation" class="active"><a href="#">Zaměstnanci</a></li>
    <li role="presentation"><a href="<?php echo LR\Filters::escapeHtmlAttr($this->global->uiPresenter->link("Pid:default")) ?>">Rodná čísla</a></li>
    <li role="presentation"><a href="<?php echo LR\Filters::escapeHtmlAttr($this->global->uiPresenter->link("Company:default")) ?>">Firmy</a></li>
    <li role="presentation"><a href="<?php echo LR\Filters::escapeHtmlAttr($this->global->uiPresenter->link("Statistic:default")) ?>">Statistiky</a></li>
    <li role="presentation"><a href="<?php echo LR\Filters::escapeHtmlAttr($this->global->uiPresenter->link("Homepage:default")) ?>">Menu</a></li>
</ul>

<div style="text-align: right">
    <a class="btn btn-success" href="<?php echo LR\Filters::escapeHtmlAttr($this->global->uiPresenter->link("add")) ?>">Vytvoř</a>
</div>

<div class="row div-table">
    <div class="col-xs-12 div-head">
        <div class="row">
            <div class="col-sm-1">Firma</div>
            <div class="col-sm-1">Jméno</div>
            <div class="col-sm-1">Příjmení</div>
            <div class="col-sm-2">Rodné číslo</div>
            <div class="col-sm-1">Pohlaví</div>
            <div class="col-sm-2">Datum narození</div>
            <div class="col-sm-1">Plat</div>
            <div class="col-sm-1">Daň</div>
            <div class="col-sm-2">Akce</div>
        </div>
    </div>
<?php
		$iterations = 0;
		foreach ($employers as $e) {
?>
        <div class="col-xs-12 div-body">
            <div class="row">
                <div class="col-sm-1"><?php echo LR\Filters::escapeHtmlText($e->company->name) /* line 34 */ ?></div>
                <div class="col-sm-1"><a href="http://www.kdejsme.cz/jmeno/<?php echo LR\Filters::escapeHtmlAttr(LR\Filters::safeUrl($e->firstname)) /* line 35 */ ?>"><?php
			echo LR\Filters::escapeHtmlText($e->firstname) /* line 35 */ ?></a></div>
                <div class="col-sm-1"><a href="http://www.kdejsme.cz/prijmeni/<?php echo LR\Filters::escapeHtmlAttr(LR\Filters::safeUrl($e->surname)) /* line 36 */ ?>"><?php
			echo LR\Filters::escapeHtmlText($e->surname) /* line 36 */ ?></a></div>
                <div class="col-sm-2">
<?php
			if ($e->pid_id) {
				if (!($utility->isCorrectPid($e->pid->name))) {
					?>                            <strong class="red">!! <?php echo LR\Filters::escapeHtmlText($e->pid->name) /* line 40 */ ?></strong>
<?php
				}
				else {
					?>                            <?php echo LR\Filters::escapeHtmlText($e->pid->name) /* line 42 */ ?>

<?php
				}
			}
			else {
?>
                        Není uvedeno
<?php
			}
?>
                </div>
                <div class="col-sm-1">
<?php
			if ($e->pid_id) {
				$isMan = $utility->isMan($e->pid_id);
				if (($isMan !== -1)) {
					?>                            <?php echo LR\Filters::escapeHtmlText($isMan ? 'Muž' : 'Žena') /* line 52 */ ?>

<?php
				}
				else {
?>
                            <strong class="red">!!</strong>
<?php
				}
			}
			else {
?>
                        Není uvedeno
<?php
			}
?>
                </div>
                <div class="col-sm-2">
<?php
			if ($e->pid_id) {
				$getBirthDay = $utility->getBirthDay($e->pid_id);
				if (($getBirthDay) != -1) {
					?>                            <?php echo LR\Filters::escapeHtmlText($getBirthDay) /* line 64 */ ?>

<?php
				}
				else {
?>
                            <strong class="red">!!</strong>
<?php
				}
			}
			else {
?>
                        Není uvedeno
<?php
			}
?>
                </div>
                <div class="col-sm-1"><?php echo LR\Filters::escapeHtmlText(call_user_func($this->filters->number, $e->salary, 2, '.', ' ')) /* line 72 */ ?></div>
                <div class="col-sm-1"><?php echo LR\Filters::escapeHtmlText(call_user_func($this->filters->number, $e->salary * 0.22, 2, '.', ' ')) /* line 73 */ ?></div>
                <div class="col-sm-2">
                    <a class="btn btn-warning" href="<?php echo LR\Filters::escapeHtmlAttr($this->global->uiPresenter->link("edit", ['id' => $e->id])) ?>">Edituj</a>
                    <a class="btn btn-danger" href="<?php echo LR\Filters::escapeHtmlAttr($this->global->uiPresenter->link("delete", ['id' => $e->id])) ?>">Odeber</a>
                </div>
            </div>
        </div>
<?php
			$iterations++;
		}
		?></div><?php
	}

}
