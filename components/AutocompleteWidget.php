<?php
/**
 * Created by PhpStorm.
 * User: d1mich
 * Date: 29.12.16
 * Time: 10:27
 */

namespace app\components;


use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\InputWidget;

/**
 * Class AutocompleteWidget
 * @package app\components
 */
class AutocompleteWidget extends InputWidget
{

    /**
     *
     */
    const API_URL = '//maps.googleapis.com/maps/api/js?';

    /**
     * @var string
     */
    public $libraries = 'places';

    /**
     * @var bool
     */
    public $sensor = true;

    /**
     * @var string
     */
    public $language = 'en-US';

    /**
     * @var array
     */
    public $autocompleteOptions = [
        'types' => [
            '(cities)'
        ]
    ];

    /**
     * @var
     */
    protected $key;

    /**
     *
     */
    public function init()
    {
        parent::init();

        $this->key = ArrayHelper::getValue(\Yii::$app->params, 'googleMapsApiKey');
    }


    /**
     * Renders the widget.
     */
    public function run()
    {
        $this->registerClientScript();
        if ($this->hasModel()) {
            echo Html::activeTextInput($this->model, $this->attribute, $this->options);
        } else {
            echo Html::textInput($this->name, $this->value, $this->options);
        }
    }

    /**
     * Registers the needed JavaScript.
     */
    public function registerClientScript()
    {
        $elementId = $this->options['id'];
        $scriptOptions = json_encode($this->autocompleteOptions);
        $view = $this->getView();
        $view->registerJsFile(self::API_URL . http_build_query([
                'key' => $this->key,
                'libraries' => $this->libraries,
                'sensor' => $this->sensor ? 'true' : 'false',
                'language' => $this->language
            ]));
        $view->registerJs(<<<JS
(function(){
    var input = document.getElementById('{$elementId}');
    var options = JSON.parse('{$scriptOptions}');
    console.log(options);
    var autocomplete = new google.maps.places.Autocomplete(input, options);
    autocomplete.addListener('place_changed', fillInAddress);
    
    function fillInAddress() {
        var place = autocomplete.getPlace();
        
        for (var i = 0; i < place.address_components.length; i++) {
            var addressType = place.address_components[i].types[0];
            var val = place.address_components[i]['long_name'];
            $('.' + addressType).val(val);
            console.log(addressType);
        }
    }
    
})();
    
JS
            , \yii\web\View::POS_READY);
    }

}