<?php
/**
 * Vino Uninstall
 *
 * Suppression des tables
 *
 * @package Vino\Desinstallation
 */

include_once __DIR__ . '/inclut/classe-vino-installer.php';

Vino_Installer::supprimer_tables();
