<?php

namespace wearemode\crafttelescope\controllers;

use Craft;
use craft\web\Controller;
use wearemode\crafttelescope\Crafttelescope;
use yii\web\BadRequestHttpException;
use yii\web\UnauthorizedHttpException;

class BaseController extends Controller
{
	public function checkAuthentication()
	{
		$headers = Craft::$app->request->getHeaders();
		$authorization = $headers->get('authorization');
		$token = Crafttelescope::$plugin->getSettings()->apiKey;

		if(!$authorization) {
			throw new BadRequestHttpException('Missing Bearer token');
		}

		if($authorization !== "Bearer {$token}") {
			throw new UnauthorizedHttpException('Invalid Bearer token');
		}
	}
}
