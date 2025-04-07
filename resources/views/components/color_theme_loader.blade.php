{{--	COLOR THEME --}}<?php
                      $color_theme = $_COOKIE["color_theme_href"] ?? asset('/css/color_theme__red.css');
                      ?>
<link id="color_theme" href="{{$color_theme}}" rel="stylesheet">