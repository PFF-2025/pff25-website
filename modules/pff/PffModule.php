<?php
namespace modules\pff;

use Craft;
use DateTime;
use Twig\TwigFunction;
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

			public function getFunctions(): array {
				return [
					new TwigFunction('pffBandTimestamp', [$this, 'pffBandTimestamp']),
					new TwigFunction('pffBandIsNowPlaying', [$this, 'pffBandIsNowPlaying']),
				];
			}

			/**
			 * Convert a day and time into a timestamp.
			 * "fr" = 29.8.2025
			 * "sa" = 30.8.2025
			 * "so" = 31.8.2025
			 *
			 * @param string $day is either "fr", "sa", or "so"
			 * @param DateTime $time is a time
			 * @return int Returns a timestamp based on the provided day and time.
			 * @throws \Exception If the day or time is invalid.
			 * @example {{ pffBandTimestamp('fr', '12:00') }}
			 * @example {{ pffBandTimestamp('sa', '23:59') }}
			 */
			public function pffBandTimestamp(string $day, DateTime $time): int {
				// Define the base date for the festival
				$baseDate = '2025-08-29'; // This is the Friday of the festival

				// Determine the day offset based on the provided day
				switch ($day) {
					case 'fr':
						$dayOffset = 0; // Friday
						break;
					case 'sa':
						$dayOffset = 1; // Saturday
						break;
					case 'so':
						$dayOffset = 2; // Sunday
						break;
					default:
						throw new \Exception('Invalid day provided. Use "fr", "sa", or "so".');
				}

				// if band is a night band (midnight to 5:59am), add 24 hours to the base timestamp
				if ($time < new DateTime('06:00')) {
					$dayOffset += 1; // Move to the next day
				}
				// Combine the base date with the day offset and time
				$dateTimeString = sprintf('%s +%d days %s', $baseDate, $dayOffset, $time->format('H:i'));

				// Convert to timestamp
				return strtotime($dateTimeString);
			}

			/**
			 * Check if a band is currently playing.
			 *
			 * @param int $startTimestamp The start timestamp of the band's performance.
			 * @param int|null $durationInMinutes The duration of the band's performance in minutes. Default is 45 minutes.
			 * @return bool Returns true if the band is currently playing, false otherwise.
			 */
			public function pffBandIsNowPlaying(int $startTimestamp, int|null $durationInMinutes): bool {
				// Default duration is 45 minutes if not provided
				$durationInMinutes = $durationInMinutes ?? 45;

				// Calculate the end timestamp based on the start timestamp and duration
				$endTimestamp = $startTimestamp + ($durationInMinutes * 60);

				// Get the current timestamp
				$currentTimestamp = time();

				// Check if the current timestamp is within the band's performance time
				return $currentTimestamp >= $startTimestamp && $currentTimestamp <= $endTimestamp;
			}
		});
	}
}
