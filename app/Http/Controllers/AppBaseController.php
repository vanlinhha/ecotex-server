<?php

namespace App\Http\Controllers;

use InfyOm\Generator\Utils\ResponseUtil;
use Response;

/**
 * @SWG\Swagger(
 *   host="localhost/ecotex",
 *   basePath="/api/v1",
 *   @SWG\Info(
 *     title="Laravel Generator APIs",
 *     version="1.0.0",
 *   )
 * )
 * This class should be parent class for other API controllers
 * Class AppBaseController
 */
class AppBaseController extends Controller
{
    public $type = ['material', 'segment', 'product', 'target', 'service', 'country', 'quantity'];
    public $mainType = [
        'material' => 'main_material_groups',
        'segment' => 'main_segment_groups',
        'product' => 'main_product_groups',
        'target' => 'main_target_groups',
        'service' => 'main_services',
        'country' => 'main_export_countries',
        'quantity' => 'minimum_order_quantity'];

    public function sendResponse($result, $message)
    {
        return Response::json(ResponseUtil::makeResponse($message, $result));
    }

    public function sendError($error, $code = 404)
    {
        return Response::json(ResponseUtil::makeError($error), $code);
    }
}
