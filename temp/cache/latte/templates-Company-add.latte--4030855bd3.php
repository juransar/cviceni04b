<?php
// source: C:\xampp\htdocs\cviceni04b\app\presenters/templates/Company/add.latte

use Latte\Runtime as LR;

class Template4030855bd3 extends Latte\Runtime\Template
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
		Nette\Bridges\ApplicationLatte\UIRuntime::initialize($this, $this->parentName, $this->blocks);
		
	}


	function blockContent($_args)
	{
		extract($_args);
?>
<h1>Vložení Firmy</h1>
<p>
<a href="<?php echo LR\Filters::escapeHtmlAttr($this->global->uiPresenter->link("default")) ?>">Zpět</a>
</p>

<?php
		/* line 7 */
		echo Nette\Bridges\FormsLatte\Runtime::renderFormBegin($form = $_form = $this->global->formsStack[] = $this->global->uiControl["addForm"], []);
?>

    <table>
        <tr class="required">
            <th><?php if ($_label = end($this->global->formsStack)["name"]->getLabel()) echo $_label ?></th>
            <td><?php echo end($this->global->formsStack)["name"]->getControl() /* line 11 */ ?></td>
            <td><?php
		echo LR\Filters::escapeHtmlText(end($this->global->formsStack)["name"]->getError());
?></td>

        </tr>
        <tr class="required">
            <th><?php if ($_label = end($this->global->formsStack)["phone"]->getLabel()) echo $_label ?></th>
            <td><?php echo end($this->global->formsStack)["phone"]->getControl() /* line 17 */ ?></td>
            <td><?php
		echo LR\Filters::escapeHtmlText(end($this->global->formsStack)["phone"]->getError());
?></td>
        </tr>
        <tr class="required">
            <th><?php if ($_label = end($this->global->formsStack)["is_dph"]->getLabel()) echo $_label ?></th>
            <td><?php echo end($this->global->formsStack)["is_dph"]->getControl() /* line 22 */ ?></td>
            <td><?php
		echo LR\Filters::escapeHtmlText(end($this->global->formsStack)["is_dph"]->getError());
?></td>
        </tr>

        <tr>
            <th><?php if ($_label = end($this->global->formsStack)["taxNum"]->getLabel()) echo $_label ?></th>
            <td><?php echo end($this->global->formsStack)["taxNum"]->getControl() /* line 28 */ ?></td>
            <td><?php
		echo LR\Filters::escapeHtmlText(end($this->global->formsStack)["taxNum"]->getError());
?></td>

        </tr>
        <tr>
            <th><?php if ($_label = end($this->global->formsStack)["send"]->getLabel()) echo $_label ?></th>
            <td><?php echo end($this->global->formsStack)["send"]->getControl() /* line 34 */ ?></td>
        </tr>
    </table>
<?php
		echo Nette\Bridges\FormsLatte\Runtime::renderFormEnd(array_pop($this->global->formsStack));
		
	}

}
