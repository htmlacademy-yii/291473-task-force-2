<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\Response;
use app\services\GeocoderService;

class ApiController extends Controller //Component
{

    public function actionGeocoder(string $geocode)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        return (new GeocoderService())->getCoords($geocode);
    }
}
