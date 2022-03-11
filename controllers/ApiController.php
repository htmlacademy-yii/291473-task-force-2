<?php

// namespace app\controllers;

// use Yii;

// class ApiController extends Controller
// {
//     public function actionGeocoder(string $geocode)
//     {
//         Yii::$app->response->format = Response::FORMAT_JSON;

//         return Yii::$app->geocoder->getCoords($geocode);
//     }
// }

namespace app\controllers;

use Yii;
use yii\base\Component;
use yii\web\Controller;
use yii\web\Response;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\BadResponseException;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Exception\ServerException;
use GuzzleHttp\Psr7\Request;
use app\services\GeocoderService;

class ApiController extends Controller //Component
{

    public function actionGeocoder(string $geocode)
    {
        // if (Yii::$app->request->isAjax) { //  Добавим проверку на AJAX-запрос, поменяем формат ответа и вернём результат в формате JSON;
        //     Yii::$app->response->format = Response::FORMAT_JSON;

        //     return ActiveForm::validate($loginForm);
        // }

        Yii::$app->response->format = Response::FORMAT_JSON;

        return (new GeocoderService())->getCoords($geocode);
    }
}
