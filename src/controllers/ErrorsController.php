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
 * Errors Controller
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
class ErrorsController extends BaseController
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
     * e.g.: actions/craft-telescope/errors
     *
     * @return mixed
     */
    public function actionIndex()
    {
	    $this->checkAuthentication();

	    $errors = Craft::$app->deprecator->getLogs();

        return $this->asJson([
            'count' => count($errors),
            'errors' => $errors,
        ]);
    }
}
