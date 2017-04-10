<?php

namespace App\Presenters;

use Nette\Application\BadRequestException;
use Nette\Application\Helpers;
use Nette\Application\IPresenter;
use Nette\Application\Request;
use Nette\Application\Responses\CallbackResponse;
use Nette\Application\Responses\ForwardResponse;
use Nette\SmartObject;
use Tracy\ILogger;

/**
 * Class ErrorPresenter
 * @package App\Presenters
 */
class ErrorPresenter implements IPresenter
{
	use SmartObject;

	/** @var ILogger */
	private $logger;

	/**
	 * ErrorPresenter constructor.
	 * @param ILogger $logger
	 */
	public function __construct(ILogger $logger)
	{
		$this->logger = $logger;
	}

	/**
	 *
	 * @param Request $request
	 * @return CallbackResponse|ForwardResponse
	 */
	public function run(Request $request)
	{
		$exception = $request->getParameter('exception');

		if ($exception instanceof BadRequestException) {
			list($module, , $sep) = Helpers::splitName($request->getPresenterName());
			return new ForwardResponse($request->setPresenterName($module . $sep . 'Error4xx'));
		}

		$this->logger->log($exception, ILogger::EXCEPTION);
		return new CallbackResponse(function () {
			require __DIR__ . '/templates/Error/500.phtml';
		});
	}
}
