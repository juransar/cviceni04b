<?php
// source: C:\xampp\htdocs\cviceni04b\app\presenters/templates/Statistic/default.latte

use Latte\Runtime as LR;

class Template8a8ba5a7ef extends Latte\Runtime\Template
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
		if (isset($this->params['s'])) trigger_error('Variable $s overwritten in foreach on line 24');
		Nette\Bridges\ApplicationLatte\UIRuntime::initialize($this, $this->parentName, $this->blocks);
		
	}


	function blockContent($_args)
	{
		extract($_args);
?>

<h1>Statistiky</h1>

<hr>
<ul class="nav nav-pills">
    <li role="presentation"><a href="<?php echo LR\Filters::escapeHtmlAttr($this->global->uiPresenter->link("Employer:default")) ?>">Zaměstnanci</a></li>
    <li role="presentation"><a href="<?php echo LR\Filters::escapeHtmlAttr($this->global->uiPresenter->link("Pid:default")) ?>">Rodná čísla</a></li>
    <li role="presentation"><a href="<?php echo LR\Filters::escapeHtmlAttr($this->global->uiPresenter->link("Company:default")) ?>">Firmy</a></li>
    <li role="presentation" class="active"><a href="#">Statistiky</a></li>
    <li role="presentation"><a href="<?php echo LR\Filters::escapeHtmlAttr($this->global->uiPresenter->link("Homepage:default")) ?>">Menu</a></li>
</ul>

<div class="row div-table">
    <div class="col-xs-12 div-head">
        <div class="row">
            <div class="col-xs-2">Firma</div>
            <div class="col-xs-3">Minimální plat ve firmě</div>
            <div class="col-xs-2">Maximální plat ve firmě</div>
            <div class="col-xs-2">Průměrný plat ve firmě</div>
            <div class="col-xs-3">Celkový plat ve firmě</div>
        </div>
    </div>
<?php
		$iterations = 0;
		foreach ($statistics as $s) {
?>
        <div class="col-xs-12 div-body">
            <div class="row">
                <div class="col-xs-2"><?php echo LR\Filters::escapeHtmlText($s['name']) /* line 27 */ ?></div>
                <div class="col-xs-3"><?php echo LR\Filters::escapeHtmlText(call_user_func($this->filters->number, $s['min'], 2, '.', ' ')) /* line 28 */ ?></div>
                <div class="col-xs-2"><?php echo LR\Filters::escapeHtmlText(call_user_func($this->filters->number, $s['max'], 2, '.', ' ')) /* line 29 */ ?></div>
                <div class="col-xs-2"><?php echo LR\Filters::escapeHtmlText(call_user_func($this->filters->number, $s['avg'], 2, '.', ' ')) /* line 30 */ ?></div>
                <div class="col-xs-3"><?php echo LR\Filters::escapeHtmlText(call_user_func($this->filters->number, $s['sum'], 2, '.', ' ')) /* line 31 */ ?></div>
            </div>
        </div>
<?php
			$iterations++;
		}
		?></div><?php
	}

}
