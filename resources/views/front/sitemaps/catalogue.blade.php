<?php
echo '<?xml version="1.0" encoding="utf-8"?>';
?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
        xmlns:image="http://www.google.com/schemas/sitemap-image/1.1"
        xmlns:video="http://www.google.com/schemas/sitemap-video/1.1">
    @foreach($catalogues as $catalogue)
    <url>
        <loc>{{route('catalogue.product',['id' => $catalogue->slug])}}</loc>
        <lastmod>2024-05-11</lastmod>
        <changefreq>monthly</changefreq>
        <priority>1.00</priority>
    </url>
    @endforeach
</urlset>
               