<?php

require_once 'ermarian/template.php';

$page['title'] = 'Converters';
$page['meta']['description'] = 'Several converters provided by the Ermarian Network.';
$page['meta']['keywords'] = ['ermarian network', 'converters', 'ermarian', 'arancaytar'];
$page['content'] = <<<DOC
    <p>The PHP tools listed below will take some of your input and convert it using a certain algorithm. Except for the travesty generator, all these scripts are self-written and entirely PHP.</p>
    <p>Some of the input/output-based and search tools include XML-based <a href="http://www.opensearch.org" class="external" title="OpenSearch site">OpenSearch</a> plugins which allow you to put the tool into your browser search box. All tools that do so also use the <a class="external" href="http://www.json.org" title="JSON site">JSON</a>-based search suggestion feature, which means that you don't need to load the site to use it - your output will be processed in real-time and shown as a search suggestion.</p>
    <ul>
      <li><a href="services/converters/ascii">Plain ASCII to Binary Converter</a></li>
      <li><a href="services/converters/coordinates">Conversion between polar and cartesian coordinates</a></li>
      <li><a href="services/converters/leet">Leet-Speak Converter</a></li>
      <li><a href="services/converters/morse">Morse Code Converter</a> (offers OpenSearch plugin for inclusion in browser search box)</li>
      <li><a href="services/converters/travesty">Markov Chain random text generator ("travesty")</a></li>
    </ul>
DOC;

print theme_page($page);
