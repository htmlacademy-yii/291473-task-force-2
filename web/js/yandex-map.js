const yandexMap = document.querySelector('#map').dataset;
ymaps.ready(init);
    function init(){
        var myMap = new ymaps.Map("map", {
            center: [yandexMap.latitude, yandexMap.longitude],
            zoom: 7
        });
    }