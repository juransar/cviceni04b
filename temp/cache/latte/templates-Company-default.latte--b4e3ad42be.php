<?php
// source: C:\xampp\htdocs\cviceni04b\app\presenters/templates/Company/default.latte

use Latte\Runtime as LR;

class Templateb4e3ad42be extends Latte\Runtime\Template
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
		if (isset($this->params['c'])) trigger_error('Variable $c overwritten in foreach on line 27');
		Nette\Bridges\ApplicationLatte\UIRuntime::initialize($this, $this->parentName, $this->blocks);
		
	}


	function blockContent($_args)
	{
		extract($_args);
?>

<h1>Firmy</h1>
<hr>
<ul class="nav nav-pills">
    <li role="presentation"><a href="<?php echo LR\Filters::escapeHtmlAttr($this->global->uiPresenter->link("Employer:default")) ?>">Zaměstnanci</a></li>
    <li role="presentation"><a href="<?php echo LR\Filters::escapeHtmlAttr($this->global->uiPresenter->link("Pid:default")) ?>">Rodná čísla</a></li>
    <li role="presentation" class="active"><a href="#">Firmy</a></li>
    <li role="presentation"><a href="<?php echo LR\Filters::escapeHtmlAttr($this->global->uiPresenter->link("Statistic:default")) ?>">Statistiky</a></li>
    <li role="presentation"><a href="<?php echo LR\Filters::escapeHtmlAttr($this->global->uiPresenter->link("Homepage:default")) ?>">Menu</a></li>
</ul>

<div style="text-align: right">
    <a class="btn btn-success" href="<?php echo LR\Filters::escapeHtmlAttr($this->global->uiPresenter->link("add")) ?>">Vytvoř</a>
</div>

<div class="row div-table">
    <div class="col-xs-12 div-head">
        <div class="row">
            <div class="col-xs-2">Jméno</div>
            <div class="col-xs-3">Registrace</div>
            <div class="col-xs-2">Je plátce DPH?</div>
            <div class="col-xs-2">Telefon</div>
            <div class="col-xs-3">Akce</div>
        </div>
    </div>
<?php
		$iterations = 0;
		foreach ($companies as $c) {
?>
        <div class="col-xs-12 div-body">
            <div class="row">
                <div class="col-xs-2"><?php echo LR\Filters::escapeHtmlText($c->name) /* line 30 */ ?></div>
                <div class="col-xs-3"><?php echo LR\Filters::escapeHtmlText(call_user_func($this->filters->date, $c->registered, 'd.m.Y - h:i:s')) /* line 31 */ ?></div>
                <div class="col-xs-2"><?php echo LR\Filters::escapeHtmlText($c->is_dph ? 'Ano' : 'Ne') /* line 32 */ ?></div>
                <div class="col-xs-2">
<?php
			if (!($utility->filterPhone($c->phone))) {
				?>                        <strong class="red">!! <?php echo LR\Filters::escapeHtmlText($c->phone) /* line 35 */ ?></strong>
<?php
			}
			else {
				?>                        <?php echo LR\Filters::escapeHtmlText($utility->filterPhone($c->phone)) /* line 37 */ ?>

<?php
			}
?>
                </div>
                <div class="col-xs-3">
                    <a class="btn btn-warning" href="<?php echo LR\Filters::escapeHtmlAttr($this->global->uiPresenter->link("edit", ['id' => $c->id])) ?>">Edituj</a>
                    <a class="btn btn-danger" href="<?php echo LR\Filters::escapeHtmlAttr($this->global->uiPresenter->link("delete", ['id' => $c->id])) ?>">Odeber</a>
                </div>
            </div>
        </div>
<?php
			$iterations++;
		}
		?></div><?php
	}

}
