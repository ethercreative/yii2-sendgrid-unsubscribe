# yii2-sendgrid-unsubscribe
A Yii2 module to easily provide public unsubscribe urls with suppression group support.

## Installation

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require ethercretaive/yii2-sendgrid-unsubscribe "~1.0.0"
```

or add

```
"ethercreative/yii2-sendgrid-unsubscribe": "~1.0.0"
```

to the require section of your `composer.json` file.

## Usage

Once the extension is installed, simply modify your application configuration as follows:

```php
return [
	'modules' => [
		'unsubscribe' => [
			'class' => 'ethercreative\unsubscribe\Module',

			// the following are optional

			// default group to unsubscribe from
			'default' => 70,

			// flash message options
			'flashMessage' => 'Your email address has successfully been unsubscribed',
			'flashGroup' => 'unsubscribe-success',

			// where to redirect to, after success
			// defaults to `Url::home()`
			'redirect' => ['/site/login'],

			// if you want to hide the IDs of your suppression groups, use `groups` to convert
			// the following will allow you to use
			//     `?email=email@address.com&group=messages`
			//     `?email=email@address.com&group=Y30JOMJjA7V7bcAC`
			'groups' => [
				'messages' => 70,
				'Y30JOMJjA7V7bcAC' => 80,
			],
		],
		// ...
	],
	// ...
];
```

You can then generate links to `/unsubscribe/?email={email}&group={id/key}

```php
Url::to(['/unsubscribe', 'email' => $email, 'group' => $group], true);
```
