<?php
$cfg['PmaNoRelation_DisableWarning'] = true;
$cfg['blowfish_secret'] = 'bcf$#dfrsfasta03';

$i=0;
$i++;
$cfg['Servers'][$i]['extension'] = 'mysql';
$cfg['Servers'][$i]['auth_type']     = 'cookie';
$cfg['Servers'][$i]['controluser']   = 'pma';
$cfg['Servers'][$i]['controlpass']   = 'pmauserpw';
$cfg['Servers'][$i]['hide_db'] = 'information_schema';
?>