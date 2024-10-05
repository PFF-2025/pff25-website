<?php
if (file_exists(__DIR__ . '/asset_version.php')) {
	include_once __DIR__ . '/asset_version.php';
}
return [
	'assetVersion' => defined('PFF25_ASSET_VERSION') ? PFF25_ASSET_VERSION : time(),
];
