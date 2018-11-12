<?php
/**
 * Created by PhpStorm.
 * User: datlp1
 * Date: 11/9/2018
 * Time: 1:20 PM
 */

	define("SLASH"			,DIRECTORY_SEPARATOR						);
	define("DOCUMENT_ROOT"	,getcwd()									);
	define("CONTROLLER_PATH",DOCUMENT_ROOT.SLASH.'controllers'.SLASH	);
	define("LIB_PATH"		,DOCUMENT_ROOT.SLASH.'libs'.SLASH			);
	define("MODEL_PATH"		,DOCUMENT_ROOT.SLASH.'models'.SLASH			);
	define("VIEW_PATH"		,DOCUMENT_ROOT.SLASH.'views'.SLASH			);
	define("PUBLIC_PATH"	,DOCUMENT_ROOT.SLASH.'public'.SLASH			);
	define("API_PATH"		,DOCUMENT_ROOT.SLASH.'api'.SLASH			);

	//== Database
	define("DB_NAME"	, "ctf_monitor"	);
	define("DB_HOST"	, "localhost"	);
	define("DB_USER"	, "root"		);
	define("DB_PASS"	, "toor"			);

