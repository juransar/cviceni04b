<?php

namespace App\Presenters;

use Nette\Application\IResponse;

/**
 * Class HomepagePresenter
 * @package App\Presenters
 */
class HomepagePresenter extends BasePresenter
{
	/** */
	protected function startup()
	{
		parent::startup();
		// TODO: Dokončit cvičení.
	}

	/** */
	public function actionDefault()
	{
	}

	/** */
	protected function beforeRender()
	{
		parent::beforeRender();
		// TODO: Dokončit cvičení.
	}

	/** */
	public function renderDefault()
	{
	}

	/** */
	protected function afterRender()
	{
		parent::afterRender();
		// TODO: Dokončit cvičení.
	}

	/**
	 *
	 * @param IResponse $response
	 */
	protected function shutdown($response)
	{
		parent::shutdown($response);
		// TODO: Dokončit cvičení.
	}
}
