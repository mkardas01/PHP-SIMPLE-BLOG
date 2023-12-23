<?php
require ('data/data.class.php');
require ('data/blogpost.class.php');
require ('data/config.php');
require ('functions.php');

Data::initialize(new MySqlDataProvider);