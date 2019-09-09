<?php
/**
 * craft-telescope plugin for Craft CMS 3.x
 *
 * Take a peek into your Craft sites from a single dashboard
 *
 * @link      https://simon-davies.name/
 * @copyright Copyright (c) 2019 Simon Davies
 */

namespace wearemode\crafttelescope\controllers;

use wearemode\crafttelescope\Crafttelescope;

use Craft;
use craft\web\Controller;

/**
 * Updates Controller
 *
 * Generally speaking, controllers are the middlemen between the front end of
 * the CP/website and your plugin’s services. They contain action methods which
 * handle individual tasks.
 *
 * A common pattern used throughout Craft involves a controller action gathering
 * post data, saving it on a model, passing the model off to a service, and then
 * responding to the request appropriately depending on the service method’s response.
 *
 * Action methods begin with the prefix “action”, followed by a description of what
 * the method does (for example, actionSaveIngredient()).
 *
 * https://craftcms.com/docs/plugins/controllers
 *
 * @author    Simon Davies
 * @package   Crafttelescope
 * @since     0.0.1
 */
class PackagesController extends Controller
{

    // Protected Properties
    // =========================================================================

    /**
     * @var    bool|array Allows anonymous access to this controller's actions.
     *         The actions must be in 'kebab-case'
     * @access protected
     */
    protected $allowAnonymous = ['index'];

    // Public Methods
    // =========================================================================

    /**
     * Handle a request going to our plugin's index action URL,
     * e.g.: actions/craft-telescope/updates
     *
     * @return mixed
     */
    public function actionIndex()
    {
        // Convert update handles to Composer package names, and capture current versions
        $pluginsService = Craft::$app->getPlugins();
	    $updates = Craft::$app->getUpdates()->getUpdates(true);

        $craft = [
        	'craftcms/cms' => [
        		'name' => 'Craft',
		        'update_available' => count($updates->cms->releases) > 0,
		        'current_version' => Craft::$app->getVersion(),
		        'latest_version' => count($updates->cms->releases) ? $updates->cms->releases[0]['version'] : null,
		        'critical' => array_reduce($updates->cms->releases, function($result, $release){
		        	return $result || $release->critical;
		        }, false),
		        'notes' => count($updates->cms->releases) > 0 ? $updates->cms->releases[0]->notes : null,
	        ]
        ];

        $plugins = [];
        foreach($updates->plugins as $handle => $plugin) {
        	$info = $pluginsService->getPluginInfo($handle);
			$plugins[$handle] = [
		        'name' => $info['name'],
                'update_available' => count($plugin->releases) > 0,
				'latest_version' => count($plugin->releases) ? $plugin->releases[0]['version'] : null,
				'current_version' => $info['version'],
				'critical' => array_reduce($plugin->releases, function($result, $release){
					return $result || $release->critical;
				}, false),
				'notes' => count($plugin->releases) > 0 ? $plugin->releases[0]->notes : null,
	        ];
        }

	    $data = array_merge($craft, $plugins);

	    return $this->asJson($data);
    }
}
