<?php
$city="Delhi";
$country="IN"; //Two digit country code
$url="http://api.openweathermap.org/data/2.5/weather?q=".$city.",".$country."&APPID=ffc0577316adb48558c2c2cfd8665a1b";
$json=file_get_contents($url);
$data=json_decode($json,true);
//Get current Temperature in Celsius
echo $data['main']['temp']."<br>";
//Get weather condition
echo $data['weather'][0]['main']."<br>";
//Get cloud percentage
echo $data['clouds']['all']."<br>";
//Get wind speed
echo $data['wind']['speed']."<br>";
?>
<script src='http://openweathermap.org/themes/openweathermap/assets/vendor/owm/js/d3.min.js'></script><div id='openweathermap-widget'></div>
                    <script type='text/javascript'>
                    window.myWidgetParam = {
                        id: 11,
                        cityid: 7279746,
                        appid: 'ffc0577316adb48558c2c2cfd8665a1b',
                        containerid: 'openweathermap-widget',
                    };
                    (function() {
                        var script = document.createElement('script');
                        script.type = 'text/javascript';
                        script.async = true;
                        script.src = 'http://openweathermap.org/themes/openweathermap/assets/vendor/owm/js/weather-widget-generator.js';
                        var s = document.getElementsByTagName('script')[0];
                        s.parentNode.insertBefore(script, s);
                    })();
                  </script>


                 <!--  <a href="https://www.accuweather.com/en/us/new-york-ny/10007/weather-forecast/349727" class="aw-widget-legal">

By accessing and/or using this code snippet, you agree to AccuWeather’s terms and conditions (in English) which can be found at https://www.accuweather.com/en/free-weather-widgets/terms and AccuWeather’s Privacy Statement (in English) which can be found at https://www.accuweather.com/en/privacy.

</a><div id="awcc1488786386095" class="aw-widget-current"  data-locationkey="" data-unit="f" data-language="en-us" data-useip="true" data-uid="awcc1488786386095"></div><script type="text/javascript" src="https://oap.accuweather.com/launch.js"></script>	 -->