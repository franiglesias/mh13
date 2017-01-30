<?php

/**
* FiMime
*/
class FiMime
{

	var $mimeType = array(
		'7z' => array('type' => 'application/x-7z-compressed', 'human' => 'application/x-7z-compressed', 'simple' => 'application/x-7z-compressed'),
		'ai' => array('type' => 'application/postscript', 'human' => 'application/postscript', 'simple' => 'application/postscript'),
		'aif' => array('type' => 'audio/x-aiff', 'human' => 'audio aiff', 'simple' => 'audio'),
		'aifc' => array('type' => 'audio/x-aiff', 'human' => 'audio aiff', 'simple' => 'audio'),
		'aiff' => array('type' => 'audio/x-aiff', 'human' => 'audio aiff', 'simple' => 'audio'),
		'asc' => array('type' => 'text/plain', 'human' => 'text plain', 'simple' => 'text'),
		'asf' => array('type' => 'video/x-ms-asf', 'human' => 'video x-ms-asf', 'simple' => 'video'),
		'asx' => array('type' => 'video/x-ms-asf', 'human' => 'video x-ms-asf', 'simple' => 'video'),
		'au' => array('type' => 'audio/basic', 'human' => 'audio basic', 'simple' => 'audio'),
		'avi' => array('type' => 'video/x-msvideo', 'human' => 'video x-msvideo', 'simple' => 'video'),
		'bcpio' => array('type' => 'application/x-bcpio', 'human' => 'application/x-bcpio', 'simple' => 'application/x-bcpio'),
		'bin' => array('type' => 'application/octet-stream', 'human' => 'application/octet-stream', 'simple' => 'application/octet-stream'),
		'bz2' => array('type' => 'application/x-bzip', 'human' => 'application/x-bzip', 'simple' => 'application/x-bzip'),
		'c' => array('type' => 'text/plain', 'human' => 'text plain', 'simple' => 'text'),
		'cc' => array('type' => 'text/plain', 'human' => 'text plain', 'simple' => 'text'),
		'ccad' => array('type' => 'application/clariscad', 'human' => 'application/clariscad', 'simple' => 'application/clariscad'),
		'cdf' => array('type' => 'application/x-netcdf', 'human' => 'application/x-netcdf', 'simple' => 'application/x-netcdf'),
		'class' => array('type' => 'application/octet-stream', 'human' => 'application/octet-stream', 'simple' => 'application/octet-stream'),
		'cpio' => array('type' => 'application/x-cpio', 'human' => 'application/x-cpio', 'simple' => 'application/x-cpio'),
		'cpt' => array('type' => 'application/mac-compactpro', 'human' => 'application/mac-compactpro', 'simple' => 'application/mac-compactpro'),
		'csh' => array('type' => 'application/x-csh', 'human' => 'application/x-csh', 'simple' => 'application/x-csh'),
		'css' => array('type' => 'text/css', 'human' => 'text css', 'simple' => 'text'),
		'csv' => array('type' => 'application/csv', 'human' => 'application/csv', 'simple' => 'application/csv'),
		'dcr' => array('type' => 'application/x-director', 'human' => 'application/x-director', 'simple' => 'application/x-director'),
		'dir' => array('type' => 'application/x-director', 'human' => 'application/x-director', 'simple' => 'application/x-director'),
		'dms' => array('type' => 'application/octet-stream', 'human' => 'application/octet-stream', 'simple' => 'application/octet-stream'),
		'doc' => array('type' => 'application/msword', 'human' => 'Word text document', 'simple' => 'text'),
		'docx' => array('type' => 'application/msword', 'human' => 'Word text document', 'simple' => 'text'),
		'drw' => array('type' => 'application/drafting', 'human' => 'application/drafting', 'simple' => 'application/drafting'),
		'dvi' => array('type' => 'application/x-dvi', 'human' => 'application/x-dvi', 'simple' => 'application/x-dvi'),
		'dwg' => array('type' => 'application/acad', 'human' => 'application/acad', 'simple' => 'application/acad'),
		'dxf' => array('type' => 'application/dxf', 'human' => 'application/dxf', 'simple' => 'application/dxf'),
		'dxr' => array('type' => 'application/x-director', 'human' => 'application/x-director', 'simple' => 'application/x-director'),
		'eps' => array('type' => 'application/postscript', 'human' => 'application/postscript', 'simple' => 'application/postscript'),
		'etx' => array('type' => 'text/x-setext', 'human' => 'text x-setext', 'simple' => 'text'),
		'exe' => array('type' => 'application/octet-stream', 'human' => 'application/octet-stream', 'simple' => 'application/octet-stream'),
		'ez' => array('type' => 'application/andrew-inset', 'human' => 'application/andrew-inset', 'simple' => 'application/andrew-inset'),
		'f' => array('type' => 'text/plain', 'human' => 'text plain', 'simple' => 'text'),
		'f90' => array('type' => 'text/plain', 'human' => 'text plain', 'simple' => 'text'),
		'fli' => array('type' => 'video/x-fli', 'human' => 'video x-fli', 'simple' => 'video'),
		'flv' => array('type' => 'video/x-flv', 'human' => 'video x-flv', 'simple' => 'video'),
		'gif' => array('type' => 'image/gif', 'human' => 'image gif', 'simple' => 'image'),
		'gtar' => array('type' => 'application/x-gtar', 'human' => 'application/x-gtar', 'simple' => 'application/x-gtar'),
		'gz' => array('type' => 'application/x-gzip', 'human' => 'application/x-gzip', 'simple' => 'application/x-gzip'),
		'h' => array('type' => 'text/plain', 'human' => 'text plain', 'simple' => 'text'),
		'hdf' => array('type' => 'application/x-hdf', 'human' => 'application/x-hdf', 'simple' => 'application/x-hdf'),
		'hh' => array('type' => 'text/plain', 'human' => 'text plain', 'simple' => 'text'),
		'hqx' => array('type' => 'application/mac-binhex40', 'human' => 'application/mac-binhex40', 'simple' => 'application/mac-binhex40'),
		'htm' => array('type' => 'text/html', 'human' => 'text html', 'simple' => 'text'),
		'html' => array('type' => 'text/html', 'human' => 'text html', 'simple' => 'text'),
		'ice' => array('type' => 'x-conference/x-cooltalk', 'human' => 'x-conference/x-cooltalk', 'simple' => 'x-conference/x-cooltalk'),
		'ief' => array('type' => 'image/ief', 'human' => 'image ief', 'simple' => 'image'),
		'iges' => array('type' => 'model/iges', 'human' => 'model/iges', 'simple' => 'model/iges'),
		'igs' => array('type' => 'model/iges', 'human' => 'model/iges', 'simple' => 'model/iges'),
		'ips' => array('type' => 'application/x-ipscript', 'human' => 'application/x-ipscript', 'simple' => 'application/x-ipscript'),
		'ipx' => array('type' => 'application/x-ipix', 'human' => 'application/x-ipix', 'simple' => 'application/x-ipix'),
		'jpe' => array('type' => 'image/jpeg', 'human' => 'image jpeg', 'simple' => 'image'),
		'jpeg' => array('type' => 'image/jpeg', 'human' => 'image jpeg', 'simple' => 'image'),
		'jpg' => array('type' => 'image/jpeg', 'human' => 'image jpeg', 'simple' => 'image'),
		'js' => array('type' => 'application/x-javascript', 'human' => 'application/x-javascript', 'simple' => 'application/x-javascript'),
		'kar' => array('type' => 'audio/midi', 'human' => 'audio midi', 'simple' => 'audio'),
		'latex' => array('type' => 'application/x-latex', 'human' => 'application/x-latex', 'simple' => 'application/x-latex'),
		'lha' => array('type' => 'application/octet-stream', 'human' => 'application/octet-stream', 'simple' => 'application/octet-stream'),
		'lsp' => array('type' => 'application/x-lisp', 'human' => 'application/x-lisp', 'simple' => 'application/x-lisp'),
		'lzh' => array('type' => 'application/octet-stream', 'human' => 'application/octet-stream', 'simple' => 'application/octet-stream'),
		'm' => array('type' => 'text/plain', 'human' => 'text plain', 'simple' => 'text'),
		'm3u' => array('type' => 'audio/x-mpegurl', 'human' => 'audio x-mpegurl', 'simple' => 'audio'),
		'm4a' => array('type' => 'audio/mp4a-latm', 'human' => 'audio mp4', 'simple' => 'audio'),
		'm4b' => array('type' => 'audio/mp4a-latm', 'human' => 'audio mp4', 'simple' => 'audio'),
		'm4p' => array('type' => 'audio/mp4a-latm', 'human' => 'audio mp4', 'simple' => 'audio'),
		'm4u' => array('type' => 'video/vnd.mpegurl', 'human' => 'video vnd.mpegurl', 'simple' => 'video'),
		'm4v' => array('type' => 'video/x-m4v', 'human' => 'video mp4', 'simple' => 'video'),
		'man' => array('type' => 'application/x-troff-man', 'human' => 'application/x-troff-man', 'simple' => 'application/x-troff-man'),
		'me' => array('type' => 'application/x-troff-me', 'human' => 'application/x-troff-me', 'simple' => 'application/x-troff-me'),
		'mesh' => array('type' => 'model/mesh', 'human' => 'model/mesh', 'simple' => 'model/mesh'),
		'mid' => array('type' => 'audio/midi', 'human' => 'audio midi', 'simple' => 'audio'),
		'midi' => array('type' => 'audio/midi', 'human' => 'audio midi', 'simple' => 'audio'),
		'mif' => array('type' => 'application/vnd.mif', 'human' => 'application/vnd.mif', 'simple' => 'application/vnd.mif'),
		'mime' => array('type' => 'www/mime', 'human' => 'www/mime', 'simple' => 'www/mime'),
		'mov' => array('type' => 'video/quicktime', 'human' => 'video quicktime', 'simple' => 'video'),
		'movie' => array('type' => 'video/x-sgi-movie', 'human' => 'video x-sgi-movie', 'simple' => 'video'),
		'mp2' => array('type' => 'audio/mpeg', 'human' => 'audio mpeg', 'simple' => 'audio'),
		'mp3' => array('type' => 'audio/mpeg', 'human' => 'audio mpeg', 'simple' => 'audio'),
		'mp4' => array('type' => 'video/x-m4v', 'human' => 'video mp4', 'simple' => 'video'),
		'mpe' => array('type' => 'video/mpeg', 'human' => 'video mpeg', 'simple' => 'video'),
		'mpeg' => array('type' => 'video/mpeg', 'human' => 'video mpeg', 'simple' => 'video'),
		'mpg' => array('type' => 'video/mpeg', 'human' => 'video mpeg', 'simple' => 'video'),
		'mpga' => array('type' => 'audio/mpeg', 'human' => 'audio mpeg', 'simple' => 'audio'),
		'ms' => array('type' => 'application/x-troff-ms', 'human' => 'application/x-troff-ms', 'simple' => 'application/x-troff-ms'),
		'msh' => array('type' => 'model/mesh', 'human' => 'model/mesh', 'simple' => 'model/mesh'),
		'nc' => array('type' => 'application/x-netcdf', 'human' => 'application/x-netcdf', 'simple' => 'application/x-netcdf'),
		'oda' => array('type' => 'application/oda', 'human' => 'application/oda', 'simple' => 'application/oda'),
		'odb' => array('type' => 'application/vnd.oasis.opendocument.database', 'human' => 'Open Office database', 'simple' => 'database'),
		'odc' => array('type' => 'application/vnd.oasis.opendocument.chart', 'human' => 'Open Office chart', 'simple' => 'chart'),
		'odf' => array('type' => 'application/vnd.oasis.opendocument.formula', 'human' => 'Open Office formula', 'simple' => 'formula'),
		'odg' => array('type' => 'application/vnd.oasis.opendocument.graphics', 'human' => 'Open Office graphics', 'simple' => 'graphics'),
		'odi' => array('type' => 'application/vnd.oasis.opendocument.image', 'human' => 'Open Office image', 'simple' => 'image'),
		'odm' => array('type' => 'application/vnd.oasis.opendocument.text-master', 'human' => 'application/vnd.oasis.opendocument.text-master', 'simple' => 'text'),
		'odp' => array('type' => 'application/vnd.oasis.opendocument.presentation', 'human' => 'Open Office presentation', 'simple' => 'presentation'),
		'ods' => array('type' => 'application/vnd.oasis.opendocument.spreadsheet', 'human' => 'Open Office spreadsheet', 'simple' => 'spreadsheet'),
		'odt' => array('type' => 'application/vnd.oasis.opendocument.text', 'human' => 'Open Office text', 'simple' => 'text'),
		'otg' => array('type' => 'application/vnd.oasis.opendocument.graphics-template', 'human' => 'Open Office graphics-template', 'simple' => 'application/vnd.oasis.opendocument.graphics-template'),
		'oth' => array('type' => 'application/vnd.oasis.opendocument.text-web', 'human' => 'application/vnd.oasis.opendocument.text-web', 'simple' => 'text-web'),
		'otp' => array('type' => 'application/vnd.oasis.opendocument.presentation-template', 'human' => 'Open Office presentation template', 'simple' => 'presentation'),
		'ots' => array('type' => 'application/vnd.oasis.opendocument.spreadsheet-template', 'human' => 'Open Office spreadsheet template', 'simple' => 'spreadsheet'),
		'ott' => array('type' => 'application/vnd.oasis.opendocument.text-template', 'human' => 'Open Office text document template', 'simple' => 'text'),
		'pages' => array('type' => 'iapplication/x-iwork-pages-sffpages', 'human' => 'Apple Pages document', 'simple' => 'text'),
		'pbm' => array('type' => 'image/x-portable-bitmap', 'human' => 'image x-portable-bitmap', 'simple' => 'image'),
		'pdb' => array('type' => 'chemical/x-pdb', 'human' => 'chemical/x-pdb', 'simple' => 'chemical/x-pdb'),
		'pdf' => array('type' => 'application/pdf', 'human' => 'pdf', 'simple' => 'pdf'),
		'pgm' => array('type' => 'image/x-portable-graymap', 'human' => 'image x-portable-graymap', 'simple' => 'image'),
		'pgn' => array('type' => 'application/x-chess-pgn', 'human' => 'application/x-chess-pgn', 'simple' => 'application/x-chess-pgn'),
		'png' => array('type' => 'image/png', 'human' => 'image png', 'simple' => 'image'),
		'pnm' => array('type' => 'image/x-portable-anymap', 'human' => 'image x-portable-anymap', 'simple' => 'image'),
		'pot' => array('type' => 'application/mspowerpoint', 'human' => 'power point presentation', 'simple' => 'presentation'),
		'ppm' => array('type' => 'image/x-portable-pixmap', 'human' => 'image x-portable-pixmap', 'simple' => 'image'),
		'pps' => array('type' => 'application/mspowerpoint', 'human' => 'power point presentation', 'simple' => 'presentation'),
		'ppt' => array('type' => 'application/mspowerpoint', 'human' => 'power point presentation', 'simple' => 'presentation'),
		'ppz' => array('type' => 'application/mspowerpoint', 'human' => 'power point presentation', 'simple' => 'presentation'),
		'pre' => array('type' => 'application/x-freelance', 'human' => 'application/x-freelance', 'simple' => 'application/x-freelance'),
		'prt' => array('type' => 'application/pro_eng', 'human' => 'application/pro_eng', 'simple' => 'application/pro_eng'),
		'ps' => array('type' => 'application/postscript', 'human' => 'application/postscript', 'simple' => 'application/postscript'),
		'qt' => array('type' => 'video/quicktime', 'human' => 'video quicktime', 'simple' => 'video'),
		'ra' => array('type' => 'audio/x-realaudio', 'human' => 'audio x-realaudio', 'simple' => 'audio'),
		'ram' => array('type' => 'audio/x-pn-realaudio', 'human' => 'audio x-pn-realaudio', 'simple' => 'audio'),
		'ras' => array('type' => 'image/cmu-raster', 'human' => 'image cmu-raster', 'simple' => 'image'),
		'rgb' => array('type' => 'image/x-rgb', 'human' => 'image x-rgb', 'simple' => 'image'),
		'rm' => array('type' => 'audio/x-pn-realaudio', 'human' => 'audio x-pn-realaudio', 'simple' => 'audio'),
		'roff' => array('type' => 'application/x-troff', 'human' => 'application/x-troff', 'simple' => 'application/x-troff'),
		'rpm' => array('type' => 'audio/x-pn-realaudio-plugin', 'human' => 'audio x-pn-realaudio-plugin', 'simple' => 'audio'),
		'rtf' => array('type' => 'text/rtf', 'human' => 'text rtf', 'simple' => 'text'),
		'rtx' => array('type' => 'text/richtext', 'human' => 'text richtext', 'simple' => 'text'),
		'scm' => array('type' => 'application/x-lotusscreencam', 'human' => 'application/x-lotusscreencam', 'simple' => 'application/x-lotusscreencam'),
		'set' => array('type' => 'application/set', 'human' => 'application/set', 'simple' => 'application/set'),
		'sgm' => array('type' => 'text/sgml', 'human' => 'text sgml', 'simple' => 'text'),
		'sgml' => array('type' => 'text/sgml', 'human' => 'text sgml', 'simple' => 'text'),
		'sh' => array('type' => 'application/x-sh', 'human' => 'application/x-sh', 'simple' => 'application/x-sh'),
		'shar' => array('type' => 'application/x-shar', 'human' => 'application/x-shar', 'simple' => 'application/x-shar'),
		'silo' => array('type' => 'model/mesh', 'human' => 'model/mesh', 'simple' => 'model/mesh'),
		'sit' => array('type' => 'application/x-stuffit', 'human' => 'application/x-stuffit', 'simple' => 'application/x-stuffit'),
		'skd' => array('type' => 'application/x-koan', 'human' => 'application/x-koan', 'simple' => 'application/x-koan'),
		'skm' => array('type' => 'application/x-koan', 'human' => 'application/x-koan', 'simple' => 'application/x-koan'),
		'skp' => array('type' => 'application/x-koan', 'human' => 'application/x-koan', 'simple' => 'application/x-koan'),
		'skt' => array('type' => 'application/x-koan', 'human' => 'application/x-koan', 'simple' => 'application/x-koan'),
		'smi' => array('type' => 'application/smil', 'human' => 'application/smil', 'simple' => 'application/smil'),
		'smil' => array('type' => 'application/smil', 'human' => 'application/smil', 'simple' => 'application/smil'),
		'snd' => array('type' => 'audio/basic', 'human' => 'audio basic', 'simple' => 'audio'),
		'sol' => array('type' => 'application/solids', 'human' => 'application/solids', 'simple' => 'application/solids'),
		'spl' => array('type' => 'application/x-futuresplash', 'human' => 'application/x-futuresplash', 'simple' => 'application/x-futuresplash'),
		'src' => array('type' => 'application/x-wais-source', 'human' => 'application/x-wais-source', 'simple' => 'application/x-wais-source'),
		'step' => array('type' => 'application/STEP', 'human' => 'application/STEP', 'simple' => 'application/STEP'),
		'stl' => array('type' => 'application/SLA', 'human' => 'application/SLA', 'simple' => 'application/SLA'),
		'stp' => array('type' => 'application/STEP', 'human' => 'application/STEP', 'simple' => 'application/STEP'),
		'sv4cpio' => array('type' => 'application/x-sv4cpio', 'human' => 'application/x-sv4cpio', 'simple' => 'application/x-sv4cpio'),
		'sv4crc' => array('type' => 'application/x-sv4crc', 'human' => 'application/x-sv4crc', 'simple' => 'application/x-sv4crc'),
		'svg' => array('type' => 'image/svg+xml', 'human' => 'image svg+xml', 'simple' => 'image'),
		'svgz' => array('type' => 'image/svg+xml', 'human' => 'image svg+xml', 'simple' => 'image'),
		'swf' => array('type' => 'application/x-shockwave-flash', 'human' => 'application/x-shockwave-flash', 'simple' => 'application/x-shockwave-flash'),
		't' => array('type' => 'application/x-troff', 'human' => 'application/x-troff', 'simple' => 'application/x-troff'),
		'tar' => array('type' => 'application/x-tar', 'human' => 'application/x-tar', 'simple' => 'application/x-tar'),
		'tcl' => array('type' => 'application/x-tcl', 'human' => 'application/x-tcl', 'simple' => 'application/x-tcl'),
		'tex' => array('type' => 'application/x-tex', 'human' => 'application/x-tex', 'simple' => 'application/x-tex'),
		'texi' => array('type' => 'application/x-texinfo', 'human' => 'application/x-texinfo', 'simple' => 'application/x-texinfo'),
		'texinfo' => array('type' => 'application/x-texinfo', 'human' => 'application/x-texinfo', 'simple' => 'application/x-texinfo'),
		'tif' => array('type' => 'image/tiff', 'human' => 'image tiff', 'simple' => 'image'),
		'tiff' => array('type' => 'image/tiff', 'human' => 'image tiff', 'simple' => 'image'),
		'tpl' => array('type' => 'text/template', 'human' => 'text template', 'simple' => 'text'),
		'tr' => array('type' => 'application/x-troff', 'human' => 'application/x-troff', 'simple' => 'application/x-troff'),
		'tsi' => array('type' => 'audio/TSP-audio', 'human' => 'audio TSP-audio', 'simple' => 'audio'),
		'tsp' => array('type' => 'application/dsptype', 'human' => 'application/dsptype', 'simple' => 'application/dsptype'),
		'tsv' => array('type' => 'text/tab-separated-values', 'human' => 'text tab-separated-values', 'simple' => 'text'),
		'txt' => array('type' => 'text/plain', 'human' => 'text plain', 'simple' => 'text'),
		'unv' => array('type' => 'application/i-deas', 'human' => 'application/i-deas', 'simple' => 'application/i-deas'),
		'ustar' => array('type' => 'application/x-ustar', 'human' => 'application/x-ustar', 'simple' => 'application/x-ustar'),
		'vcd' => array('type' => 'application/x-cdlink', 'human' => 'application/x-cdlink', 'simple' => 'application/x-cdlink'),
		'vda' => array('type' => 'application/vda', 'human' => 'application/vda', 'simple' => 'application/vda'),
		'viv' => array('type' => 'video/vnd.vivo', 'human' => 'video vnd.vivo', 'simple' => 'video'),
		'vivo' => array('type' => 'video/vnd.vivo', 'human' => 'video vnd.vivo', 'simple' => 'video'),
		'vrml' => array('type' => 'model/vrml', 'human' => 'model/vrml', 'simple' => 'model/vrml'),
		'wav' => array('type' => 'audio/x-wav', 'human' => 'audio x-wav', 'simple' => 'audio'),
		'wax' => array('type' => 'audio/x-ms-wax', 'human' => 'audio x-ms-wax', 'simple' => 'audio'),
		'wm' => array('type' => 'video/x-ms-wm', 'human' => 'video x-ms-wm', 'simple' => 'video'),
		'wma' => array('type' => 'audio/x-ms-wma', 'human' => 'audio windows media', 'simple' => 'audio'),
		'wmd' => array('type' => 'application/x-ms-wmd', 'human' => 'application/x-ms-wmd', 'simple' => 'application/x-ms-wmd'),
		'wmv' => array('type' => 'audio/x-ms-wmv', 'human' => 'audio windows media', 'simple' => 'audio'),
		'wmx' => array('type' => 'video/x-ms-wmx', 'human' => 'video x-ms-wmx', 'simple' => 'video'),
		'wmz' => array('type' => 'application/x-ms-wmz', 'human' => 'application/x-ms-wmz', 'simple' => 'application/x-ms-wmz'),
		'wrl' => array('type' => 'model/vrml', 'human' => 'model/vrml', 'simple' => 'model/vrml'),
		'wvx' => array('type' => 'video/x-ms-wvx', 'human' => 'video x-ms-wvx', 'simple' => 'video'),
		'xbm' => array('type' => 'image/x-xbitmap', 'human' => 'image x-xbitmap', 'simple' => 'image'),
		'xlc' => array('type' => 'application/vnd.ms-excel', 'human' => 'excel spreadsheet', 'simple' => 'spreadsheet'),
		'xll' => array('type' => 'application/vnd.ms-excel', 'human' => 'excel spreadsheet', 'simple' => 'spreadsheet'),
		'xlm' => array('type' => 'application/vnd.ms-excel', 'human' => 'excel spreadsheet', 'simple' => 'spreadsheet'),
		'xls' => array('type' => 'application/vnd.ms-excel', 'human' => 'excel spreadsheet', 'simple' => 'spreadsheet'),
		'xlw' => array('type' => 'application/vnd.ms-excel', 'human' => 'excel spreadsheet', 'simple' => 'spreadsheet'),
		'xml' => array('type' => 'text/xml', 'human' => 'text xml', 'simple' => 'text'),
		'xpm' => array('type' => 'image/x-xpixmap', 'human' => 'image x-xpixmap', 'simple' => 'image'),
		'xwd' => array('type' => 'image/x-xwindowdump', 'human' => 'image x-xwindowdump', 'simple' => 'image'),
		'xyz' => array('type' => 'chemical/x-pdb', 'human' => 'chemical/x-pdb', 'simple' => 'chemical/x-pdb'),
		'zip' => array('type' => 'application/zip', 'human' => 'application/zip', 'simple' => 'application/zip'),
		
		);

/**
 * Mime type from extension
 *
 * @param string $extension 
 * @param string $mode (type), human, simple
 * @return string
 */
	public function ext2Mime($extension, $mode = 'type')
	{
		$generic = array(
			'type' => 'generic file',
			'human' => 'file',
			'simple' => 'file'
		);
		$extension = strtolower($extension);
		if (isset($this->mimeType[$extension])) {
			return $this->mimeType[$extension][$mode];
		}
		
		return $generic[$mode];
	}

/**
 * The mime type of the file in $filename
 *
 * @param string $filename The path to the file
 * @return string the mime type
 */	
	public function type($filename)
	{
		$filename = basename($filename);
		$extension = substr($filename, strrpos($filename, '.') + 1);
		return $this->ext2Mime($extension);
	}

/**
 * A more human readable version of the type
 *
 * @param string $filename 
 * @return string the type
 */
	public function humanType($filename)
	{
		$filename = basename($filename);
		$extension = substr($filename, strrpos($filename, '.') + 1);
		return $this->ext2Mime($extension, 'human');
	}
	
/**
 * A simplified type, mainly for previews
 *
 * @param string $filename 
 * @return string the type
 */
	public function simpleType($filename)
	{
		$filename = basename($filename);
		$extension = substr($filename, strrpos($filename, '.') + 1);
		return $this->ext2Mime($extension, 'simple');
	}
}


?>