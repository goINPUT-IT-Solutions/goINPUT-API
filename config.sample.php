<?php
/*
 *             _____ _   _ _____  _    _ _______
 *            |_   _| \ | |  __ \| |  | |__   __|
 *   __ _  ___  | | |  \| | |__) | |  | |  | |
 *  / _` |/ _ \ | | | . ` |  ___/| |  | |  | |
 * | (_| | (_) || |_| |\  | |    | |__| |  | |
 *  \__, |\___/_____|_| \_|_|     \____/   |_|
 *   __/ |
 *  |___/
 *
 *  Copyright (c) goINPUT IT Solutions 2022.
 */

const BASEDIR = __DIR__;

$config = array(
    'serverVersion' => '1.0',
    'serverName'    => 'Hayward',
    'apiVersion' => '1.0',
    'externalIP' => '0.0.0.0',
    'externalPort' => '8080',
    'ACAO' => '*',
    'ACAH' => '*',
    
    'logs' => array(
        'accessLogs' => true,
        'logToFile' => true
    ),
    
    'database' => array(
        'host'          => 'odin.goitservers.com',
        'user'          => 'cap',
        'db'            => 'cap',
        'password'      => ''
    )
);

