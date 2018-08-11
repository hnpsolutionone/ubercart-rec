<?php
$s1 = "Lorem Ipsum wwe ww  qqqee is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.";
$s2 = "Lorem Ipsum ww is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.";
require('string_compare.inc.php');
$phpStringCompare = new StringCompare($s1, $s2,
								array('remove_html_tags'=>false, 'remove_extra_spaces'=>true,
								'remove_punctuation'=>true, 'punctuation_symbols'=>Array('.', ','))
							);
$percent = $phpStringCompare->getSimilarityPercentage();
$percent2 = $phpStringCompare->getDifferencePercentage();
echo $s1. '<br> <strong>and</strong> <br>' . $s2 . '<br><br> are ' . $percent . '% similar and ' . $percent2 . '% different';