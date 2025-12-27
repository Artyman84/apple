<?php

namespace backend\assets;

use Yii;
use yii\base\InvalidConfigException;
use yii\web\AssetBundle;
use yii\web\JqueryAsset;

/**
 * Main backend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css',
        'css/site.css',
    ];
    public $js = [
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap5\BootstrapAsset',
    ];

    /**
     * @throws InvalidConfigException
     */
    public function init(): void
    {
        parent::init();
        $controllerId = Yii::$app->controller->id ?? 'site';
        $actionId = Yii::$app->controller->action->id ?? 'index';

        $this->registerControllerJs($controllerId, $actionId);
    }

    /**
     * @param string $controller
     * @param string $action
     *
     * @return void
     *
     * @throws InvalidConfigException
     */
    private function registerControllerJs(string $controller, string $action): void
    {
        $jsFilePath = Yii::getAlias("@webroot/js/views/{$controller}/{$action}.js");
        $jsFileUrl = Yii::getAlias("@web/js/views/{$controller}/{$action}.js");

        if (file_exists($jsFilePath)) {
            Yii::$app->view->registerJsFile($jsFileUrl, ['depends' => JqueryAsset::class]);
        }
    }
}
