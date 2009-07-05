<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.google.com/schemas/sitemap/0.84">
<?php foreach ($articles as $article): ?>
    <url>
      <loc><?php echo $article->public_url(TRUE); ?></loc>
      <lastmod><?php echo date('Y-m-d', $article->published); ?></lastmod>
      <changefreq>weekly</changefreq>
    </url>
<?php endforeach; ?>
<?php foreach ($tags as $tag): ?>
    <url>
      <loc><?php echo $tag->public_url(TRUE); ?></loc>
      <lastmod><?php echo date('Y-m-d', $tag->lastmod); ?></lastmod>
      <changefreq>weekly</changefreq>
    </url>
<?php endforeach; ?>
</urlset>