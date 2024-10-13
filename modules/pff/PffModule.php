<?php
namespace modules\pff;

use Craft;
use yii\base\Module;
use Twig\TwigFilter;

class PffModule extends Module
{
	public function init()
	{
		parent::init();

		Craft::$app->view->registerTwigExtension(new class extends \Twig\Extension\AbstractExtension {
			public function getFilters() {
				return [
					new TwigFilter('translateStage', [$this, 'translateStageFunction']),
					new TwigFilter('translateDay', [$this, 'translateDayFunction']),
				];
			}

			public function translateStageFunction($value) {
				// get current language
				switch (Craft::$app->language) {
					// TODO: richtige Übersetzungen für die Stages
					case 'de':
					case 'fr':
					case 'it':
						switch ($value) {
							case 'main': return 'Main-Stage';
							case 'second': return 'Tent-Stage';
						}
				}
				return $value;
			}

			public function translateDayFunction($value) {
				// get current language
				switch (Craft::$app->language) {
					case 'de':
						switch ($value) {
							case 'fr': return 'Freitag';
							case 'sa': return 'Samstag';
							case 'so': return 'Sonntag';
						}
					case 'fr':
						switch ($value) {
							case 'fr': return 'Vendredi';
							case 'sa': return 'Samedi';
							case 'so': return 'Dimanche';
						}
					case 'it':
						switch ($value) {
							case 'fr': return 'Venerdì';
							case 'sa': return 'Sabato';
							case 'so': return 'Domenica';
						}
				}
				return $value;
			}
		});
	}
}
