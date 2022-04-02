<?php

namespace app\controllers;

use Yii;
use yii\web\Response;
use app\services\GeocoderService;

class ApiController extends SecuredController
{
    /**
     * @param string $geocode
     * 
     * @return array
     */
    public function actionGeocoder(string $geocode): array
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        return (new GeocoderService())->getCoords($geocode);
    }
}
