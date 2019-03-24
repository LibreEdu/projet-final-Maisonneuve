<?php

function base_url()
{
	return BASEURL;
}

function site_url($url)
{
	return base_url() . 'index.php?' . $url;
}