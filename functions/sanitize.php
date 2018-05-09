<?php

function escape($string) {
	return htmlentities($string, ENT_QUOTES, "UTF-8");
	// ENT_QUOTES will escape single/double quoutes
}
