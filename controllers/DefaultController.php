<?php

namespace ethercreative\unsubscribe\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\helpers\Json;
use yii\helpers\Url;
use yii\web\ForbiddenHttpException;
use yii\web\HttpException;

class DefaultController extends \yii\web\Controller
{
	public function actionIndex($email, $g = null)
	{
		$module = Yii::$app->controller->module;
		$params = $module->params;

		$group = $g;
		$sendgrid = new \SendGrid($params['key'] ? $params['key'] : Yii::$app->sendgrid->key);

		if (!$group && $params['default'])
			$group = $params['default'];

		if (!is_numeric($group))
			$group = $params['groups'][$group];

		$response = $sendgrid->postRequest('https://api.sendgrid.com/v3/asm/groups/'.(int)$group.'/suppressions', Json::encode([
			'recipient_emails' => [$email],
		])); 

		if (!empty($response->code))
		{
			if ($response->code < 400)
			{
				if (!empty($params['flashMessage']) && !empty($params['flashGroup']))
				{
					Yii::$app->session->addFlash($params['flashGroup'], $params['flashMessage']);
				}

				$redirect = $params['redirect'];

				if (!$redirect) $redirect = Url::home();

				if (is_array($redirect) && $redirect[0][0] != '/')
				{
					$redirect[0] = '/' . $redirect[0];
				}

				$this->redirect($redirect);
			}
			else
			{
				throw new HttpException((int) $response->code, $response->body['errors'][0]['message']);
			}
		}
		else
		{
			throw new HttpException(400, 'No response found.');
		}
	}
}
