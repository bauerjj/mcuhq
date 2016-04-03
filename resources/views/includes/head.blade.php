<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>@yield('title')</title>
<meta name="Description" content="@yield('meta')">

<link rel="shortcut icon" href="/assets/img/favicon.png"/>
<meta name="_token" content="{{ csrf_token() }}"/>
<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ekko-lightbox/4.0.1/ekko-lightbox.min.css">
{!! Minify::stylesheet(array("/assets/css/style-blue.css","/assets/css/width-full.css",
 "/assets/css/animate.min.css","/assets/css/jquery.bxslider.min.css", "/css/custom.css")) !!}
<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!--[if lt IE 9]>
{!! Minify::javascript("/assets/js/html5shiv.min.js") !!}
{!! Minify::javascript("/assets/js/respond.min.js") !!}
<![endif]-->
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/highlight.js/9.2.0/styles/solarized-dark.min.css">
<script type="application/ld+json">
{
  "@context" : "http://schema.org",
  "@type" : "WebSite",
  "name" : "mcuhq",
  "alternateName" : "mcuHQ",
  "url" : "http://mcuhq.com"
}
</script>
<script type="application/ld+json">
{
  "@context": "http://schema.org",
  "@type": "WebSite",
  "url": "http://mcuhq.com/",
  "potentialAction": {
    "@type": "SearchAction",
    "target": "http://mcuhq.com/search?q={search_term_string}",
    "query-input": "required name=search_term_string"
  }
}
</script>