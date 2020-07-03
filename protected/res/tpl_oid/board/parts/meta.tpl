<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="<?=$pageDescription;?>">
<meta name="keywords" content="<?=$keywords;?>">
<meta property="og:url" content="<?=$protocol;?>://<?=$domain;?><?=$_SERVER['REAL_REQUEST_URI'];?>" />
<meta property="og:site_name" content="<?=$sitename;?>" />
<meta property="og:image" content="<?=$pageImage;?>" />
<meta property="og:title" content="<?=strlen($pageTitle)>0?$pageTitle:$sitename;?>" />
<meta property="og:description" content="<?=$pageDescription;?>" />
<meta property="og:locale" content="<?=$locale;?>" />
<meta property="og:type" content="article" />
<meta name="twitter:card" content="summary" />
<meta name="twitter:site" content="<?=$twitter;?>" />
<meta name="twitter:title" content="<?=strlen($pageTitle)>0?$pageTitle:$sitename;?>" />
<meta name="twitter:description" content="<?=$pageDescription;?>" />
<meta name="twitter:image" content="<?=$pageImage;?>" />
<meta name="theme-color" content="#000">