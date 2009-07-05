<?xml version="1.0" encoding="utf-8" ?>
<rss version="2.0">
  <channel>
    <title>Название блога такое-то</title>
    <link><?php echo url::base(); ?></link>
    <description>Коротко про этот блог</description>
    <pubDate><?php echo gmdate('D, d M Y H:i:s', $pub_date) . ' GMT'; ?></pubDate>    
    <lastBuildDate><?php echo gmdate('D, d M Y H:i:s', $pub_date) . ' GMT'; ?></lastBuildDate>
  <?php foreach ($articles as $article): ?>
    <item>
      <title><?php echo $article->name; ?></title>
      <link><?php echo $article->public_url(TRUE); ?></link>
      <description><?php echo strip_tags($article->summary); ?></description>
      <pubDate><?php echo gmdate('D, d M Y H:i:s', $article->published) . ' GMT'; ?></pubDate>
    </item>
  <?php endforeach; ?>
  </channel>
</rss>