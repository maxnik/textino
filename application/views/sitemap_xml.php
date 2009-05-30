<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.google.com/schemas/sitemap/0.84">
<?php foreach ($records as $record): ?>
    <url>
      <loc><?php echo $record->public_url(TRUE); ?></loc>
      <lastmod><?php echo date('Y-m-d', $record->published); ?></lastmod>
      <changefreq>weekly</changefreq>
    </url>
<?php endforeach; ?>
</urlset>