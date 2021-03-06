<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>@yield('title')</title>
<meta name="Description" content="@yield('meta')">

{{--<link rel="shortcut icon" href="/assets/img/favicon.png"/>--}}
<link rel="icon" type="image/png" href="/assets/img/favicon-32x32.png" sizes="32x32" />
<link rel="icon" type="image/png" href="/assets/img/favicon-16x16.png" sizes="16x16" />

<meta name="_token" content="{{ csrf_token() }}"/>
<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ekko-lightbox/4.0.1/ekko-lightbox.min.css">


<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slidebars/0.10.2/slidebars.min.css">


{!! Minify::stylesheet(array("/assets/css/style-blue.css","/assets/css/width-full.css",
 "/assets/css/animate.min.css","/assets/css/jquery.bxslider.min.css", "/css/custom.css", "/vendor/comments/css/comments.css")) !!}
<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!--[if lt IE 9]>
{!! Minify::javascript("/assets/js/html5shiv.min.js") !!}
{!! Minify::javascript("/assets/js/respond.min.js") !!}
<![endif]-->
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/highlight.js/9.2.0/styles/github.min.css">
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
<script async src="//pagead2.googlesyndication.com/
pagead/js/adsbygoogle.js"></script>
<script>
(adsbygoogle = window.adsbygoogle || []).push({
google_ad_client: "pub-3802569564910134",
enable_page_level_ads: true
});
</script> 