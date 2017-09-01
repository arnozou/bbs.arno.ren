<?php

namespace App\Repositories\Traits;

trait MarkdownTrait {

  protected function parseMarkdownOnly($text)
  {
    return parsedown($text);
  }

  protected function filterMDHtml($htmlText)
  {
    // clean($htmlText);
    $outputText = \Purifier::clean($htmlText);
    return $outputText;
  }

  public function parseMarkdown($markdownText)
  {
    return $this->filterMDHtml($this->parseMarkdownOnly($markdownText));
  }
}