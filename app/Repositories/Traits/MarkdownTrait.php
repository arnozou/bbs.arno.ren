<?php

namespace App\Repositories\Traits;

trait MarkdownTrait {

  protected function parseMarkdownOnly($text)
  {
    /*return Parsedown::instance()
    ->setBreaksEnabled(true) # enables automatic line breaks
    ->text($text); */
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