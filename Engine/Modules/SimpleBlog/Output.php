<?php 
  $Output = '';
  $blogPosts = $this->Database->Query("SELECT * FROM `blog` ORDER BY `posted` DESC");
  while($entry = mysqli_fetch_assoc($blogPosts))
  {
    $postTemplate = new Template('blogPost');
    $postTemplate->SetVariable('post[id]', $entry['id']);
    $postTemplate->SetVariable('post[title]', $entry['title']);
    $postTemplate->SetVariable('post[author]', $entry['author']);
    $postTemplate->SetVariable('post[time]', date('l jS \of F Y h:i:s A'), $entry['posted']);
    $postTemplate->SetVariable('post[content]', $entry['content']);

    $Output = $Output . $postTemplate->GetOutput();
  }
?>