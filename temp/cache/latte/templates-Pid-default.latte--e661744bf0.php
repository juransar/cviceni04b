<?php
// source: C:\xampp\htdocs\cviceni04b\app\presenters/templates/Pid/default.latte

use Latte\Runtime as LR;

class Templatee661744bf0 extends Latte\Runtime\Template
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
		if (isset($this->params['pid'])) trigger_error('Variable $pid overwritten in foreach on line 25');
		Nette\Bridges\ApplicationLatte\UIRuntime::initialize($this, $this->parentName, $this->blocks);
		
	}


	function blockContent($_args)
	{
		extract($_args);
?>

<h1>Rodná čísla</h1>

<hr>
<ul class="nav nav-pills">
    <li role="presentation"><a href="<?php echo LR\Filters::escapeHtmlAttr($this->global->uiPresenter->link("Employer:default")) ?>">Zaměstnanci</a></li>
    <li role="presentation" class="active"><a href="#">Rodná čísla</a></li>
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
            <div class="col-xs-6">Rodné číslo</div>
            <div class="col-xs-6">Akce</div>
        </div>
    </div>
<?php
		$iterations = 0;
		foreach ($pids as $pid) {
?>
        <div class="col-xs-12 div-body">
            <div class="row">
                <div class="col-xs-6">
<?php
			if (!($utility->isCorrectPid($pid['name']))) {
				?>                        <strong class="red">!! <?php echo LR\Filters::escapeHtmlText($pid['name']) /* line 30 */ ?></strong>
<?php
			}
			else {
				?>                        <?php echo LR\Filters::escapeHtmlText($pid['name']) /* line 32 */ ?>

<?php
			}
?>
                </div>
                <div class="col-xs-6">
                    <a class="btn btn-warning" href="<?php echo LR\Filters::escapeHtmlAttr($this->global->uiPresenter->link("edit", ['id' => $pid['id']])) ?>">Edituj</a>
                    <a class="btn btn-danger" href="<?php echo LR\Filters::escapeHtmlAttr($this->global->uiPresenter->link("delete", ['id' => $pid['id']])) ?>">Odeber</a>
                </div>
            </div>
        </div>
<?php
			$iterations++;
		}
		?></div><?php
	}

}
