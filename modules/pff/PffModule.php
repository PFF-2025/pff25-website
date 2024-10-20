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
//			public function getFilters() {
//				return [
//					new TwigFilter('translateStage', [$this, 'translateStageFunction']),
//				];
//			}

//			public function translateStageFunction($value) {
//				return $value;
//			}
		});
	}
}
