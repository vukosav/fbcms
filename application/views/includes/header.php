<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Twitter -->
    <meta name="twitter:site" content="@themepixels">
    <meta name="twitter:creator" content="@themepixels">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="Katniss">
    <meta name="twitter:description" content="Premium Quality and Responsive UI for Dashboard.">
    <meta name="twitter:image" content="http://themepixels.me/katniss/img/katniss-social.png">

    <!-- Facebook -->
    <meta property="og:url" content="http://themepixels.me/katniss">
    <meta property="og:title" content="Bracket">
    <meta property="og:description" content="Premium Quality and Responsive UI for Dashboard.">

    <meta property="og:image" content="http://themepixels.me/katniss/img/katniss-social.png">
    <meta property="og:image:secure_url" content="http://themepixels.me/katniss/img/katniss-social.png">
    <meta property="og:image:type" content="image/png">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="600">

    <!-- Meta -->
    <meta name="description" content="Premium Quality and Responsive UI for Dashboard.">
    <meta name="author" content="ThemePixels">

    <title><?php echo $title; ?></title>

    <!-- vendor css -->
    <link href="<?=base_url()?>theme/lib/font-awesome/css/font-awesome.css" rel="stylesheet">
    <link href="<?=base_url()?>theme/lib/Ionicons/css/ionicons.css" rel="stylesheet">
    <link href="<?=base_url()?>theme/lib/perfect-scrollbar/css/perfect-scrollbar.css" rel="stylesheet">
    <link href="<?=base_url()?>theme/lib/highlightjs/github.css" rel="stylesheet">
    <link href="<?=base_url()?>theme/lib/datatables/jquery.dataTables.css" rel="stylesheet">
    <link href="<?=base_url()?>theme/lib/select2/css/select2.min.css" rel="stylesheet">
    <link href="<?=base_url()?>theme/lib/rickshaw/rickshaw.min.css" rel="stylesheet">

    <!-- Katniss CSS -->
    <link rel="stylesheet" href="<?=base_url()?>theme/css/katniss.css">
  </head>

  <body>

    <!-- ##### SIDEBAR LOGO ##### -->
    <div class="kt-sideleft-header">
      <div class="kt-logo"><a href="<?=base_url()?>">Datadata</a></div>
      <div id="ktDate" class="kt-date-today"></div>
      <div class="input-group kt-input-search">
        <input type="text" class="form-control" placeholder="Search...">
        <span class="input-group-btn mg-0">
          <button class="btn"><i class="fa fa-search"></i></button>
        </span>
      </div><!-- input-group -->
    </div><!-- kt-sideleft-header -->